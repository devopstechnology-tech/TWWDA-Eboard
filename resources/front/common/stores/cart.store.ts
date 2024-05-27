import {defineStore} from 'pinia';
import {ref} from 'vue';
import {CartItem} from '@/common/types/types';


const useCartStore = defineStore('cart', () => {
    const initialized = ref<boolean>(false);
    const cartItems = ref<CartItem[]>([]);

    function addToCart(e: CartItem) {
        if (!cartItems.value.some(data => data.class_id === e.class_id)) {
            cartItems.value.push({
                ...e,
                quantity: 1,
            });
        } else {
            const cartItem = cartItems.value.find(item => item.id ===
                e.id);
            if (cartItem?.quantity) {
                ++cartItem.quantity;
            }
        }
    }

    function totalItems() {
        let sum = 0;
        cartItems.value.map(x => {
            sum = sum + x?.quantity;
        });
        return sum;
    }

    function totalAmount() {
        let sum = 0;
        cartItems.value.map(x => {
            sum = sum + (x?.quantity * x?.amount);
        });
        return sum;
    }

    function removeFromCart(e: CartItem) {
        cartItems.value = cartItems.value.filter((item) => item.id !== e.id);
    }

    function clearCart() {
        cartItems.value = [];
    }


    function initialize() {
        if (initialized.value) {
            return;
        }


        initialized.value = true;
    }

    return {
        initialize,
        initialized,
        cartItems,
        addToCart,
        removeFromCart,
        clearCart,
        totalItems,
        totalAmount,
    };
});

export default useCartStore;
