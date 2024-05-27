<template>
    <section :style="`background-image: url(${Image})`"
             class="h-full bg-no-repeat bg-cover bg-center">
        <div class="text-white  h-full w-full bg-black/20 backdrop-brightness-50">
            <div class="flex flex-col items-center justify-center">
                <h1 class="text-6xl mx-12 font-bold mt-12">Having any issues? <br><span
                    class="text-4xl flex mt-6 justify-center items-center text-center">
                    We are here to help</span></h1>
                <p class="mt-5 lg:w-6/12 mx-12 text-lg text-center">
                    We are here to answer any questions you may have.
                    Reach Out to Our Team Today!
                </p>
            </div>
            <div class="flex justify-center items-center flex-col gap-12 mx-12 my-12">
                <div class="lg:w-8/12 justify-center items-center p-5 w-full flex flex-col gap-2 order-2">
                    <h1 class="text-3xl mb-3">Interested in learning more about our solutions?</h1>
                    <div class="flex w-1/2 mx-auto gap-6 items-center">
                        <FontAwesomeIcon :icon="faEnvelope"/>
                        <h4 class="text-center">info@erev.co.ke</h4>
                    </div>
                    <div class="flex gap-6 w-1/2 mx-auto items-center">
                        <FontAwesomeIcon :icon="faPhone"/>
                        <h4>+254 706 798 820</h4>
                    </div>
                </div>
                <div class="lg:w-8/12 w-full px-5 rounded">
                    <div class="font-thin text-sm ">
                        <form novalidate @submit="onSubmit"
                              class="">
                            <div class="flex gap-3 lg:flex-row flex-col">
                                <FormInput
                                    label="Enter Your First Name"
                                    name="firstname"
                                    class="text-white w-full text-sm  tracking-wide"
                                    placeholder="Enter your first name"
                                    type="text"
                                />
                                <FormInput
                                    label="Enter Your Last Name"
                                    name="lastname"
                                    class="text-white w-full text-sm  tracking-wide"
                                    placeholder="Enter your last name"
                                    type="text"
                                />
                            </div>
                            <div class="flex gap-3 lg:flex-row flex-col">
                                <FormInput
                                    label="Enter Email Address"
                                    name="email"
                                    class="text-white w-full text-sm tracking-wide"
                                    placeholder="Enter your Email"
                                    type="email"
                                />
                                <FormInput
                                    label="Enter Phone Number"
                                    name="email"
                                    class="text-white w-full text-sm tracking-wide"
                                    placeholder="Enter your Phone Number"
                                    type="number"
                                />
                            </div>
                            <RadioButton
                                :options="options"
                                title="Select Subject"
                                name="subject"/>
                            <FormTextBox
                                name="message"
                                label="Enter Message"
                                placeholder="Enter your message"/>
                            <button type="submit" class="login-button mb-1 w-full  mt-4">SubMit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang='ts' setup>
import Image from '@assets/images/contact.svg';
import {faEnvelope, faPhone} from '@fortawesome/free-solid-svg-icons';
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome';
import {useForm} from 'vee-validate';
import {ref} from 'vue';
import FormInput from '@/common/components/FormInput.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import RadioButton from '@/common/components/RadioButton.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
import ValidationError from '@/common/errors/ValidationError';

const options = ref([
    {name: 'Support', value: 'support'},
    {name: 'Error', value: 'error'},
    {name: 'Complaint', value: 'complaint'},
    {name: 'Compliment', value: 'compliment'},
    {name: 'General', value: 'general'},
]);
const handleUnexpectedError = useUnexpectedErrorHandler();
const {handleSubmit, setErrors, setFieldError, setFieldValue} = useForm<{
    firstname: string;
    lastname: string;
    email: string;
    subject: string;
    remember: boolean;
}>({
    initialValues: {
        firstname: '',
        lastname: '',
        email: '',
        subject: '',
        remember: false,
    },
});

const onSubmit = handleSubmit(async (values) => {
    try {
        console.log(values); // eslint-disable-line
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);

            if (err.messages._) {
                setFieldError('email', err.messages._);
            }
        } else {
            setFieldError('email', 'Something went wrong.');
            handleUnexpectedError(err);
        }
    } finally {
        setFieldValue('firstname', '');
    }
});
</script>

<style scoped>
.login-button {
    @apply bg-secondary text-white flex items-center justify-center font-bold;
    @apply rounded-md h-12;
    @apply uppercase;
}
</style>
