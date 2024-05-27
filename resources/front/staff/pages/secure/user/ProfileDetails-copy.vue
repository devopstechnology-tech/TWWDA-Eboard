<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
import {useForm} from 'vee-validate';
import {onMounted,ref} from 'vue';
import {useRoute,useRouter} from 'vue-router';
import * as yup from 'yup';
import {useGetProfileRequest, useUpdateProfileRequest} from '@/common/api/requests/modules/user/useProfileRequest';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormUpload from '@/common/components/FormUpload.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
// Import your API function
import {
    formatDate,
    loadAvatar,
    loadDefaultCover,
    loadDefaultUserIcon,
    profileChangeImage,
    resetProfileImage,
    supportedImageTypes,
    updateProfileImage,
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {User} from '@/common/parsers/userParser';
import queryClient from '@/queryClient';


// Get the route instance
const route = useRoute();
const router = useRouter();
const profileId = route.params.profileId as string;
const userId = route.params.userId as string;
const handleUnexpectedError = useUnexpectedErrorHandler();
function goBack() {
    resetForm();
    router.back();
}
// conflict
const userchema = yup.object({
    id:yup.string().required(),
    first:yup.string().required(),
    last:yup.string().required(),
    other_names:yup.string().nullable(),
    email:yup.string().required(),
    password:yup.string().required().nullable(),
    // profile setting
    avatar:yup.string().nullable(),
    ethnicity:yup.string().nullable(),
    phone:yup.string().nullable(),
    idpassportnumber:yup.string().nullable(),
    gender_id:yup.string().nullable(),
    about:yup.string().nullable(),
    //address
    address:yup.string().nullable(),
    home_county_id:yup.string().nullable(),
    residence_county_id:yup.string().nullable(),
    city:yup.string().nullable(),
    state:yup.string().nullable(),
    nationality:yup.string().nullable(),
    // self documentsinfo
    kra_pin:yup.string().nullable(),
    member_cv:yup.string().nullable(),
    //:official
    establishment:yup.string().nullable(),
    title:yup.string().nullable(),
    appointing_authority:yup.string().nullable(),
    appointnment_date:yup.string().nullable(),
    appointment_letter:yup.string().nullable(),
    appointment_end_date:yup.string().nullable(),
    serving_term:yup.string().nullable(),
    current_period:yup.string().nullable(),
    user_id:yup.string().required(),
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    //user
    id: string;
    first: string;
    last: string;
    other_names: string | null;
    email: string;
    password: string| null;
    // profile setting
    avatar:string | null,
    ethnicity:string | null,
    phone:string | null,
    idpassportnumber:string | null,
    gender_id:string | null,
    about:string | null,
    //address
    address:string | null,
    home_county_id:string | null,
    residence_county_id:string | null,
    city:string | null,
    state:string | null,
    nationality:string | null,
    //self documentsinfo
    kra_pin:string | null,
    member_cv:string | null,
    //official
    establishment:string | null,
    title:string | null,
    appointing_authority:string | null,
    appointnment_date:string | null,
    appointment_letter:string | null,
    appointment_end_date:string | null,
    serving_term:string | null,
    current_period:string | null,
    user_id:string,

}>({
    validationSchema: userchema,
    initialValues: {
        id:profileId,
        first:'',
        last:'',
        other_names:null,
        email:'',
        password:null,
        // profile setting
        avatar:null,
        ethnicity:null,
        phone:null,
        idpassportnumber:null,
        gender_id:null,
        about:null,
        // address
        address:null,
        home_county_id:null,
        residence_county_id:null,
        city:null,
        state:null,
        nationality:null,
        // self documentsinfo
        kra_pin:null,
        member_cv:null,
        // official:null,
        establishment:null,
        title:null,
        appointing_authority:null,
        appointnment_date:null,
        appointment_letter:null,
        appointment_end_date:null,
        serving_term:null,
        current_period:null,
        user_id:userId,
    },
});
const onSubmit = handleSubmit(async (values) => {
    try {

        const response = await useUpdateProfileRequest(values, profileId);
        const profileData = response.data;
        // Now manually update your local state and vue-query cache
        populateForm(profileData); // Populate form with the updated data
        queryClient.setQueryData(['getProfileKey'], profileData); // Update the cache with the new data
        resetProfileImage();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});
const populateForm = (data)=>{
    setFieldValue('id', profileId);
    setFieldValue('first', data.user.first);
    setFieldValue('last', data.user.last);
    setFieldValue('other_names', data.user.other_names? data.user.other_names :null);
    setFieldValue('email', data.user.email);
    setFieldValue('password', null);
    // profile setting
    setFieldValue('avatar', data.avatar? data.avatar: null);
    updateProfileImage(data.avatar? data.avatar: null);
    setFieldValue('ethnicity', data.ethnicity? data.ethnicity: null);
    setFieldValue('phone', data.phone? data.phone: null);
    setFieldValue('idpassportnumber', data.idpassportnumber? data.idpassportnumber: null);
    setFieldValue('gender_id', data.gender_id? data.gender_id: null);
    setFieldValue('about', data.about? data.about: null);
    // address
    setFieldValue('address', data.address? data.address: null);
    setFieldValue('home_county_id', data.home_county_id? data.home_county_id: null);
    setFieldValue('residence_county_id', data.residence_county_id? data.residence_county_id: null);
    setFieldValue('city', data.city? data.city: null);
    setFieldValue('state', data.state? data.state: null);
    setFieldValue('nationality', data.nationality? data.nationality: null);
    // self documentsinfo
    setFieldValue('kra_pin', data.kra_pin? data.kra_pin: null);
    setFieldValue('member_cv', data.member_cv? data.member_cv: null);
    // official:null,
    setFieldValue('establishment', data.establishment? data.establishment: null);
    setFieldValue('title', data.title? data.title: null);
    setFieldValue('appointing_authority', data.appointing_authority? data.appointing_authority: null);
    setFieldValue('appointnment_date', data.appointnment_date? data.appointnment_date: null);
    setFieldValue('appointment_letter', data.appointment_letter? data.appointment_letter: null);
    setFieldValue('appointment_end_date', data.appointment_end_date? data.appointment_end_date: null);
    setFieldValue('serving_term', data.serving_term? data.serving_term: null);
    setFieldValue('current_period', data.current_period? data.current_period: null);
    setFieldValue('user_id', userId);

    window.dispatchEvent(new CustomEvent('updateTitle', {detail: data.user.full_name + ' Profile'}));
};
const resetForm = ()=>{
    setFieldValue('id', '');
    setFieldValue('first', '');
    setFieldValue('last', '');
    setFieldValue('other_names', null);
    setFieldValue('email','' );
    setFieldValue('password', null);
    // profile setting
    setFieldValue('avatar', null);
    setFieldValue('ethnicity', null);
    setFieldValue('phone',null);
    setFieldValue('idpassportnumber',  null);
    setFieldValue('gender_id',  null);
    setFieldValue('about', null);
    // address
    setFieldValue('address', null);
    setFieldValue('home_county_id', null);
    setFieldValue('residence_county_id',null);
    setFieldValue('city', null);
    setFieldValue('state', null);
    setFieldValue('nationality', null);
    // self documentsinfo
    setFieldValue('kra_pin', null);
    setFieldValue('member_cv', null);
    // official:null,
    setFieldValue('establishment', null);
    setFieldValue('title',  null);
    setFieldValue('appointing_authority', null);
    setFieldValue('appointnment_date', null);
    setFieldValue('appointment_letter',  null);
    setFieldValue('appointment_end_date',null);
    setFieldValue('serving_term', null);
    setFieldValue('current_period', null);
    setFieldValue('user_id', '');

    window.dispatchEvent(new CustomEvent('updateTitle', {detail:null + ' Profile'}));
};
onMounted(async () => {
    await fetchProfile();
});
const getProfile = () => {
    return useQuery({
        queryKey: ['getProfileKey'],
        queryFn: async () => {
            const response = await useGetProfileRequest(profileId);
            populateForm(response.data);
            return response.data;
        },
    });
};

const {isLoading, data: fetchedProfile, refetch: fetchProfile} = getProfile();

</script>

<template>
    <div class="col-md-12" v-if="fetchedProfile">
        <div class="card card-widget widget-user shadow-lg" >
            <div class="widget-user-header text-white"
                 :style="{ background: `url(${loadDefaultCover('default.png')}) center center` } "
                 style="height: 250px;">
            </div>
            <div class="card-footer" >
                <div class="d-flex align-items-center">
                    <span class=""
                          style="transform: translate(-50%, 0); position: absolute; top: 210px; left: 60px;">
                        <img class="profile-user-img img-fluid img-circle"
                             :src="loadAvatar(fetchedProfile.avatar)" alt="User profile picture">
                    </span>
                    <div class="ml-3 flex-1" style=" margin-top: -10px;">
                        <a href="" @click.prevent="goBack()"
                           class="text-blue-primary" style="margin-left: 75px;">
                            <i class="fas fa-chevron-left"></i> Go back
                        </a>
                        <h3 class="h2"> {{ fetchedProfile?.user.full_name}}</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.widget-user -->
    </div>
    <div class="container-fluid">
        <div class="row" v-if="fetchedProfile">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profileinfo">
                        <div class="text-center">
                            <img class="profileinfo-user-img img-fluid img-circle"
                                 :src="loadAvatar(fetchedProfile.avatar)" alt="User profileinfo picture">
                                 
                        </div>
                        <h3 class="profileinfo-username text-center"> {{ fetchedProfile?.user.full_name}}</h3>
                        <p class="text-muted text-center"> {{ fetchedProfile?.title}}</p>
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">About Me</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-book mr-1"></i> {{fetchedProfile?.title }}</strong>
                        <p class="text-muted">
                            Appointed By: 
                            <span class="text-primary font-bold">
                                {{ fetchedProfile?.appointing_authority }}
                            </span>                            
                        </p>
                        <p class="text-muted">
                            from : 
                            <span class="text-success font-bold">
                                {{ formatDate(fetchedProfile?.appointnment_date) }} 
                            </span>
                            to 
                            <span class="text-success font-bold">
                                {{ formatDate(fetchedProfile?.appointment_end_date) }}
                            </span>
                        </p>
                        <p class="text-muted">
                            serving term: 
                            <span class="text-primary font-bold">
                                {{ fetchedProfile?.serving_term }}
                            </span>
                        </p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> My Profile</strong>
                        <p class="text-muted">Ethnicity:
                            <span class="text-danger font-bold">{{fetchedProfile?.ethnicity }}</span>
                        </p>
                        <p class="text-muted">ID/Passport Number:
                            <span class="text-primary font-bold">{{fetchedProfile?.idpassportnumber }}</span>
                        </p>
                        <p class="text-muted">Phone:
                            <span class="text-danger font-bold">{{fetchedProfile?.phone }}</span>
                        </p>
                        <p class="text-muted">Address:
                            <span class="text-danger font-bold">{{fetchedProfile?.address }}</span>
                        </p>
                        <p class="text-muted">Home County:
                            <span class="text-danger font-bold">{{fetchedProfile?.home_county_id }} </span>
                        </p>
                        <p class="text-muted">Residential County:
                            <span class="text-danger font-bold">{{fetchedProfile?.residence_county_id }}</span>
                        </p>
                        <p class="text-muted">City:
                            <span class="text-danger font-bold">{{fetchedProfile?.city }}</span>
                        </p>
                        <p class="text-muted">State:
                            <span class="text-danger font-bold">{{fetchedProfile?.state }}</span>
                        </p>
                        <p class="text-muted">Nationality:
                            <span class="text-danger font-bold">{{fetchedProfile?.nationality }}</span>
                        </p>
                        <hr>
                        <strong><i class="far fa-file-alt mr-1"></i> About Me</strong>
                        <p class="text-muted">{{fetchedProfile?.about }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i>
                            Profile Setting
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 col-sm-3">
                                <div class="nav flex-column nav-pills h-100" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link active" id="vert-tabs-logininfo-tab"
                                       data-toggle="pill" href="#vert-tabs-logininfo"
                                       role="tab" aria-controls="vert-tabs-logininfo" aria-selected="true">
                                        Login Info
                                    </a>
                                    <a class="nav-link" id="vert-tabs-profileinfo-tab"
                                       data-toggle="pill" href="#vert-tabs-profileinfo"
                                       role="tab" aria-controls="vert-tabs-profileinfo" aria-selected="false">
                                        Profile Info
                                    </a>
                                    <a class="nav-link" id="vert-tabs-address-tab"
                                       data-toggle="pill" href="#vert-tabs-address"
                                       role="tab" aria-controls="vert-tabs-address" aria-selected="false">
                                        Address Info
                                    </a>
                                    <a class="nav-link" id="vert-tabs-documentsinfo-tab"
                                       data-toggle="pill" href="#vert-tabs-documentsinfo"
                                       role="tab" aria-controls="vert-tabs-documentsinfo" aria-selected="false">
                                        Documents Info
                                    </a>
                                    <a class="nav-link" id="vert-tabs-official-tab"
                                       data-toggle="pill" href="#vert-tabs-officialinfo"
                                       role="tab" aria-controls="vert-tabs-officialinfo" aria-selected="false">
                                        Official Info
                                    </a>
                                </div>
                            </div>
                            <div class="col-7 col-sm-9">
                                <div class="tab-content" id="vert-tabs-tabContent">
                                    <div class="tab-pane fade active show" id="vert-tabs-logininfo"
                                         role="tabpanel" aria-labelledby="vert-tabs-logininfo-tab">
                                        <form novalidate @submit="onSubmit">
                                            <div class="row mb-3">
                                                <FormInput
                                                    direction="up"
                                                    :labeled="true"
                                                    label="First Name"
                                                    name="first"
                                                    class="col-md-6 w-full text-sm  tracking-wide"
                                                    placeholder="Enter your First Name"
                                                    type="text"
                                                />
                                                <FormInput
                                                    direction="up"
                                                    :labeled="true"
                                                    label="Last Name"
                                                    name="last"
                                                    class="col-md-6 mb-2 w-full text-sm  tracking-wide"
                                                    placeholder="Enter your Last Name"
                                                    type="text"
                                                />
                                                <FormInput
                                                    direction="up"
                                                    :labeled="true"
                                                    label="Other Names"
                                                    name="other_names"
                                                    class="col-md-6 mb-2 w-full text-sm  tracking-wide"
                                                    placeholder="Enter your Other Names"
                                                    type="text"
                                                />
                                                <FormInput
                                                    direction="up"
                                                    :labeled="true"
                                                    label="Email **"
                                                    name="email"
                                                    class="col-md-6 mb-2 w-full text-sm  tracking-wide"
                                                    placeholder="Enter your Email"
                                                    type="email"
                                                    :disabled="true"
                                                />
                                                <FormInput
                                                    direction="up"
                                                    :labeled="true"
                                                    label="Password **"
                                                    name="password"
                                                    class="col-md-6 mb-2 w-full text-sm tracking-wide"
                                                    placeholder="*****"
                                                    type="text"
                                                />
                                            </div>
                                            <div class="row">
                                                <div class=" col-md-4">
                                                    <button  type="submit" class="btn btn-primary btn-block">
                                                        Update
                                                    </button>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="vert-tabs-profileinfo"
                                         role="tabpanel" aria-labelledby="vert-tabs-profileinfo-tab">
                                        <form novalidate @submit="onSubmit">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <FormUpload
                                                                :labeled="true"
                                                                direction="up"
                                                                label="Upload the Profile Image"
                                                                name="avatar"
                                                                class="col-md-12 w-full text-sm  tracking-wide mb-2"
                                                                placeholder="Enter your Photo"
                                                                type="file"
                                                                :accept="supportedImageTypes.join(', ')"
                                                                @change="profileChangeImage($event)"
                                                            />
                                                        </div>
                                                        <div class="col-md-6" v-if="values.avatar">
                                                            <img :src="updateProfileImage(values.avatar)"
                                                                 class="file_attachment"/>
                                                        </div>   
                                                    </div> 
                                                </div>
                                                                                            
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Ethnic Group"
                                                    name="ethnicity"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your Ethnic Group"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Phone"
                                                    name="phone"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your Phone Number"
                                                    type="number"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="ID Or Passport Number"
                                                    name="idpassportnumber"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your ID or Passport Number"
                                                    type="number"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Gender"
                                                    name="gender_id"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your Gender"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="About"
                                                    name="about"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your About"
                                                    type="text"
                                                />
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-4">
                                                    <button  type="submit" class="btn btn-primary btn-block">
                                                        Update
                                                    </button>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="vert-tabs-address"
                                         role="tabpanel" aria-labelledby="vert-tabs-address-tab">
                                        <form novalidate @submit="onSubmit">
                                            <div class="row mb-3">
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Address"
                                                    name="address"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your Address"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Home County"
                                                    name="home_county_id"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your Home County"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Residential County"
                                                    name="residence_county_id"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your Residential County"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="City"
                                                    name="city"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your City"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="State"
                                                    name="state"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your State"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Nationality"
                                                    name="nationality"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your Nationality"
                                                    type="text"
                                                />
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-4">
                                                    <button  type="submit" class="btn btn-primary btn-block">
                                                        Update
                                                    </button>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="vert-tabs-documentsinfo"
                                         role="tabpanel" aria-labelledby="vert-tabs-documentsinfo-tab">
                                        <form novalidate @submit="onSubmit">
                                            <div class="row mb-3">
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="KRA Pin"
                                                    name="kra_pin"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your KRA Pin"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="CV"
                                                    name="member_cv"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter your CV"
                                                    type="text"
                                                />
                                            </div>
                                            <div class="row">
                                                <div class=" col-md-4">
                                                    <button  type="submit" class="btn btn-primary btn-block">
                                                        Update
                                                    </button>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="vert-tabs-officialinfo"
                                         role="tabpanel" aria-labelledby="vert-tabs-officialinfo-tab">
                                        <form novalidate @submit="onSubmit">
                                            <div class="row mb-3">
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Establishment"
                                                    name="establishment"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter the Establishment"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Title"
                                                    name="title"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter the Title"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Appointing Authority"
                                                    name="appointing_authority"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter the Appointing Authority"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Appointment Letter"
                                                    name="appointment_letter"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter the Appointment Letter"
                                                    type="text"
                                                />
                                                <FormDateTimeInput
                                                    label="Date of Appointment"
                                                    name="appointnment_date"
                                                    :flow="['day']"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter Date of Appointment"
                                                />
                                                <FormDateTimeInput
                                                    label="Appointment End Date"
                                                    name="appointment_end_date"
                                                    :flow="['day']"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter Appointment End Date"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Serving Term"
                                                    name="serving_term"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter the Serving Term"
                                                    type="text"
                                                />
                                                <FormInput
                                                    :labeled="true"
                                                    direction="up"
                                                    label="Current Period"
                                                    name="current_period"
                                                    class="col-md-6 w-full text-sm  tracking-wide col-md-6 mb-2"
                                                    placeholder="Enter the Current Period"
                                                    type="text"
                                                />
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-4">
                                                    <button  type="submit" class="btn btn-primary btn-block">
                                                        Update
                                                    </button>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

