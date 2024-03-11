import "./bootstrap";

import "~resources/scss/app.scss";
import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**"]);

// Delete Modal
const deleteBtns = document.querySelectorAll(".delete-btn");

deleteBtns.forEach(button => {
    button.addEventListener('click', (event) => {
        event.preventDefault();
        const deleteModal = new bootstrap.Modal('#modal-delete');
        const title = button.getAttribute('data-title');
        document.getElementById('elem-title').innerHTML = title;
        deleteModal.show();
        document
            .getElementById('action-delete')
            .addEventListener('click', () => {
                button.parentElement.submit();
            })
        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', () => {
                deleteModal.hide();
                document.querySelector('.modal-backdrop').style.position = 'unset';
            })
        })
    });
})

// DefDelete Modal
const defDeleteBtns = document.querySelectorAll(".def-delete-btn");

defDeleteBtns.forEach(button => {
    button.addEventListener('click', (event) => {
        event.preventDefault();
        const defDeleteModal = new bootstrap.Modal('#modal-def-delete');
        defDeleteModal.show();
        document
            .getElementById('action-delete')
            .addEventListener('click', () => {
                button.parentElement.submit();
            })
        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', () => {
                defDeleteModal.hide();
                document.querySelector('.modal-backdrop').style.position = 'unset';
            })
        })
    });
})
