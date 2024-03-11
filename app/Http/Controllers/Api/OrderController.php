<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\OrderRequest;
use App\Mail\newleed;
use App\Models\Customer;
use App\Models\Food;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Braintree\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function validation(Request $request)
    {
        $rules = [
            'first_name' => ['required', 'string', 'min:2', 'max:20'],
            'last_name' => ['required', 'string', 'min:2', 'max:20'],
            'address' => ['required', 'string', 'min:2', 'max:30'],
            'phone' => ['required', 'string', 'min:8', 'max:15'],
            'total_amount' => ['required', 'numeric', 'not_in:0'],
            'restaurant_id' => ['required', 'numeric'],
            'foods' => ['required', 'array'],
            'foods.*' => ['numeric'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['numeric']
        ];

        $customAttributes = [
            'first_name' => 'nome',
            'last_name' => 'cognome',
            'address' => 'indirizzo',
            'phone' => 'telefono',
            'total_amount' => 'importo',
            'restaurant_id' => 'id_ristorante',
            'foods' => 'cibi',
            'quantity' => 'quantità'
        ];

        $customMessages = [
            'required' => 'Il campo :attribute è richiesto.',
            'string' => 'Il campo :attribute deve contenere solo caratteri.',
            'min' => 'Lunghezza non valida',
            'max' => 'Lunghezza non valida',
            'numeric' => 'Il campo :attribute deve essere un numero.',
            'not_in' => 'Il campo :attribute non può essere 0.',
            'array' => 'Il campo :attribute deve essere un array.',
            'foods.*.numeric' => 'Ogni elemento di foods deve essere un numero.',
            'quantity.*.numeric' => 'Ogni elemento di quantity deve essere un numero.'
        ];

        $validator = Validator::make($request->all(), $rules, $customMessages, $customAttributes);

        $foods = $request['foods'];
        $disp = true;

        foreach ($foods as $food_id) {
            $item = Food::where('id', $food_id)->first();
            if(!$item->available) {
                $disp = false;
                break;
            }
        }

        if ($validator->fails() || !$disp) {
            $validator->errors()->add('foods', 'Uno o più cibi ordinati non sono più disponibili.');
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ]);
        } else {
            return response()->json(['success' => true], 200);
        }
    }

    public function store(Request $request)
    {
        $requestData = $request->all();

        $first_name = $requestData['first_name'];
        $last_name = $requestData['last_name'];
        $address = $requestData['address'];
        $phone = $requestData['phone'];
        $total_amount = $requestData['total_amount'];
        $restaurant_id = $requestData['restaurant_id'];
        $foods = $requestData['foods'];
        $quantity = $requestData['quantity'];
        $arrayLength = count($foods);

        $customer = Customer::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'address' => $address,
            'phone' => $phone
        ]);

        $order = Order::create([
            'total_amount' => $total_amount,
            'restaurant_id' => $restaurant_id,
            'customer_id' => $customer->id
        ]);

        for ($i = 0; $i < $arrayLength; $i++) {
            $order->foods()->attach($foods[$i], ['quantity_ordered' => $quantity[$i]]);
        }


        $restaurant = Restaurant::where('id', $restaurant_id)->first();
        $email = User::where('id', $restaurant->user_id)->first();

        Mail::to('admin@devvery.com')->send(new newleed($email, $order, $customer));

        return response()->json([
            'result' => 'la nostra api funziona', $email, $order, $customer,
            'success' => true
        ]);
    }

    public function generate(Request $request, Gateway $gateway)
    {

        // Creo la funzione che mi ritorna il token di braintree per gestire il pagamento
        $token = $gateway->clientToken()->generate();
        $data = [
            'token' => $token,
            'success' => true
        ];
        return response()->json($data, 200);
    }

    public function makePayment(OrderRequest $request, Gateway $gateway)
    {

        $result = $gateway->transaction()->sale([
            'amount' => $request->amount,
            'paymentMethodNonce' => $request->token,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            $data = [
                'message' => 'Transazione eseguita',
                'success' => true
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Transazione fallita',
                'success' => false
            ];
            return response()->json($data, 401);
        }
    }
}
