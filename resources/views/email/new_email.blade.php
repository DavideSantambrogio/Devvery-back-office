

<h2>Buongiorno {{ $email->name }}</h2>
<p>E stato eseguito un ordine dal totale di {{ $order->total_amount }}€ dal signore {{ $customer->first_name }} {{ $customer->last_name }}. </p>
<p>Il numero dell'ordine è {{ $order->id }}.</p>
<p>Il recapito telefonico è: {{ $customer->phone }}</p>


<h2 class="fs-1" style="color: #fdb633">Devvery</h2>
