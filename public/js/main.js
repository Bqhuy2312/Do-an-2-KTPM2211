function updateQuantity(button, change) {
    const quantityInput = button.parentElement.querySelector('.quantity-input');
    let currentValue = parseInt(quantityInput.value);

    if (!isNaN(currentValue)) {
        let newValue = currentValue + change;
        if (newValue >= 1) {
            quantityInput.value = newValue;
        }
    }
}