<script setup lang="ts">
import {useQuery} from '@tanstack/vue-query';
// import Multiselect from '@vueform/multiselect';
import PSPDFKit from 'pspdfkit';
import {v4 as uuidv4} from 'uuid';
import {useField, useForm} from 'vee-validate';
import {computed,onMounted,ref, watch} from 'vue';
import {useRoute,useRouter} from 'vue-router';
import * as yup from 'yup';
import {array} from 'zod';
import {useUpdateSettingRequest} from '@/common/api/requests/modules/setting/useSettingRequest';
import {useGetProfileRequest, useUpdateProfileRequest} from '@/common/api/requests/modules/user/useProfileRequest';
import FormDateTimeInput from '@/common/components/FormDateTimeInput.vue';
import FormInput from '@/common/components/FormInput.vue';
import FormObjectSelect from '@/common/components/FormObjectSelect.vue';
import FormSelect from '@/common/components/FormSelect.vue';
import FormTextBox from '@/common/components/FormTextBox.vue';
import FormUpload from '@/common/components/FormUpload.vue';
import useUnexpectedErrorHandler from '@/common/composables/useUnexpectedErrorHandler';
// Import your API function
import {
    getIconAndColor,
    getInputType,
    isoChangeImage,
    loadDefaultCover,
    loadIsologo,
    loadLogo,
    loadTextlogo,
    logoChangeImage,
    resetIsoImage,
    resetLogoImage,
    resetTextlogoImage,
    textlogoChangeImage,
    updateIsoImage,
    updateLogoImage,
    updateTextlogoImage,
} from '@/common/customisation/Breadcrumb';
import ValidationError from '@/common/errors/ValidationError';
import {MailType, Settings, SettingsRequestPayload} from '@/common/parsers/settingsParser';
import useAuthStore from '@/common/stores/auth.store';
import {useMailTypesStore} from '@/common/stores/mailtypes.store';
import {useSettingsStore} from '@/common/stores/settings.store';


const authStore = useAuthStore();

// Get the route instance
const router = useRouter();
const handleUnexpectedError = useUnexpectedErrorHandler();
type MultiselectClasses = {
    container: string,
    tagRemove: string,
    tagRemoveIcon: string,
    clearIcon: string,
    tag: string,
};

const customClasses: MultiselectClasses = ref({
    container: 'multiselect',
    tagRemove: 'hide-icon',
    tagRemoveIcon: 'hide-icon',
    clearIcon: 'hide-icon',
    tag: 'multiselect-tag w-3/4',  // Use the class directly
}).value;

const settingsStore = useSettingsStore();
const mailtypesStore = useMailTypesStore();
// Reactive reference to the mailTypes
// const mailtypes = mailtypesStore.getMailTypes() || [];
// const companysettings = settingsStore.getSettings();
// let companysettings = ref<Settings | null>(settingsStore.getSettings());
const selectedMailType = ref<MailType[] | []>([]);

function goBack() {
    resetForm();
    router.back();
};
const fileSchema = yup.mixed().test(
    'fileOrString',
    'Must be a file or a string',
    value => (value instanceof File) || typeof value === 'string',
);
// conflict
const valueSchema = yup.object({
    nameField: yup.string().required(),
    namePlaceholder: yup.string().required(),
    valueName: yup.string().required('This Value is required'),
});
const mailSchema = yup.object({
    id: yup.string().required(),
    name: yup.string().required('This Value is required'),
    active: yup.string().required(),
    values: yup.array().of(valueSchema).required(),
});
const userchema = yup.object({
    id: yup.string().nullable(),
    logo: fileSchema.nullable(),
    textlogo: fileSchema.nullable(),
    name: yup.string().nullable(),
    about: yup.string().nullable(),
    website: yup.string().nullable(),
    iso: yup.string().nullable(),
    isologo: fileSchema.nullable(),
    address: yup.string().nullable(),
    county: yup.string().nullable(),
    city: yup.string().nullable(),
    state: yup.string().nullable(),
    phone1: yup.string().nullable(),
    phone2: yup.string().nullable(),    
    pspdkitlicencekey: yup.string().nullable(),
    mailtype: mailSchema,
});
const {
    handleSubmit,
    setErrors,
    setFieldValue,
    values,
} = useForm<{
    id:string;
    logo:File | string;
    textlogo:File | string;
    name:string;
    about:string;
    website:string;
    iso:string;
    isologo:File | string;
    address:string;
    county:string;
    city:string;
    state:string;
    phone1:string;
    phone2:string;
    pspdkitlicencekey:string;    
    mailtype:{
        id:string,
        name:string,
        active:string,
        values:{
            nameField:string,
            namePlaceholder:string,
            valueName:string,
        }[],
    };
    fakemailtype:{
        id:string,
        name:string,
        active:string,
        values:{
            nameField:string,
            namePlaceholder:string,
            valueName:string,
        }[],
    };

}>({
    validationSchema: userchema,
    initialValues: {
        id:'',
        logo:'',
        textlogo:'',
        name:'',
        about:'',
        website:'',
        iso:'',
        isologo:'',
        address:'',
        county:'',
        city:'',
        state:'',
        phone1:'',
        phone2:'',
        pspdkitlicencekey:'',  
        mailtype:{
            id:'',
            name:'',
            active:'inactive',
            values:[],
        },
    },
});
const {errorMessage:errorMessagemailtype} = useField('mailtype');
const onSubmit = handleSubmit(async (values) => {
    try {
        const payload: SettingsRequestPayload = {
            id: values.id,
            logo: values.logo,
            textlogo: values.textlogo,
            name: values.name,
            about: values.about,
            website: values.website,
            iso: values.iso,
            isologo: values.isologo,
            address: values.address,
            county: values.county,
            city: values.city,
            state: values.state,
            phone1: values.phone1,
            phone2: values.phone2,
            pspdkitlicencekey: values.pspdkitlicencekey,
            mailtype: values.mailtype,
        };
        await useUpdateSettingRequest(payload);       
        resetForm();
        requestpopulateForm();
    } catch (err) {
        if (err instanceof ValidationError) {
            setErrors(err.messages);
        } else {
            handleUnexpectedError(err);
        }
    }
});


const resetForm = ()=>{
    resetIsoImage();
    resetLogoImage();
    resetTextlogoImage();
    setFieldValue('id', '');
    setFieldValue('logo', '');
    setFieldValue('textlogo', '');
    setFieldValue('name', '');
    setFieldValue('about', '');
    setFieldValue('website', '');
    setFieldValue('iso', '');
    setFieldValue('isologo', '');
    setFieldValue('address', '');
    setFieldValue('county', '');
    setFieldValue('city', '');
    setFieldValue('state', '');
    setFieldValue('phone1', '');
    setFieldValue('phone2', '');
    setFieldValue('pspdkitlicencekey', '');
    setFieldValue('mailtype', {
        id: '',
        name: '',
        active: '',
        values: [],
    });
};
const requestpopulateForm = ()=>{
    if (companySettings.value !== null) {
        populateForm(companySettings.value);
    } else {
        console.log('No settings available to populate the form.');
    }
};
// const selectedmailtype = (mailtype:MailType) => {
const selectedmailtype = (selectedOption:MailType) => {
    selectedMailType.value = [selectedOption];
};
// Watch for changes in selectedMailType to perform side effects
watch(selectedMailType, (newValue, oldValue) => {
    setFieldValue('mailtype', newValue[0]);
});
watch(() => settingsStore.getSettings(), (newSettings) => {
    if (newSettings){
        populateForm(newSettings);
    }
});

//populate the form
const populateForm = (settings: Settings) => {    
    resetForm();
    Object.keys(settings).forEach((key) => {
        const valueKey = key as keyof typeof settings; // Type assertion
        setFieldValue(valueKey, settings[valueKey]);
    });
    selectedMailType.value = [settings.mailtype];     
};

//MAILTYPES SETUP ARRAY
const mailTypeOptions = computed(() => {
    return mailtypesStore.getMailTypes();
});

//Company settings 
const companySettings = computed(() => {
    return settingsStore.getSettings();
});
// onMounted(async () => {
//     if (companySettings.value !== null) {
//         populateForm(companySettings.value);
//     } else {
//         // Handle the case where settings are null, possibly initialize form with defaults
//         console.log('No settings available to populate the form.');
//     }
// });
onMounted(() => {
    if (companySettings.value !== null) {
        populateForm(companySettings.value);
    } else {
        console.log('No settings available to populate the form.');
    }
});
console.log('companySettings', companySettings.value);
</script>

<template>
    <div class="container-fluid" v-if="companySettings">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card card-widget widget-user shadow-lg">
                    <div class="widget-user-header text-white"
                         :style="{ background: `url(${loadDefaultCover('default.png')}) center center` }"
                         style="height: 250px;">
                    </div>
                    <div class="card-footer" >
                        <div class="d-flex align-items-center">
                            <span class=""
                                  style="transform: translate(-50%, 0); position: absolute; top: 210px; left: 60px;">
                                <img class="profile-user-img img-fluid img-circle"
                                     :src="loadIsologo(companySettings.isologo)" alt="User profile picture">
                                     <!-- :src="loadLogo(companySettings.logo)" alt="User profile picture"> -->
                            </span>
                            <div class="ml-3 flex-1" style=" margin-top: -10px;">
                                <a href="" @click.prevent="goBack()"
                                   class="text-blue-primary" style="margin-left: 75px;">
                                    <i class="fas fa-chevron-left"></i> Go back
                                </a>
                                <h3 class="h2">{{ companySettings.name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <!-- Profile Card with AdminLTE Style -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 :src="loadLogo(companySettings.logo)" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center font-bold text-blue-primary">
                            {{ companySettings.name }}
                        </h3>
                        <p class="text-muted text-justified">{{ companySettings.about }}</p>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 :src="loadTextlogo(companySettings.textlogo)" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center font-bold text-blue-primary">Text Logo</h3>
                    </div>
                </div>
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 :src="loadIsologo(companySettings.isologo)" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center font-bold text-blue-primary">Iso Logo</h3>
                        <p class="text-center font-bold text-success">{{ companySettings.iso }}</p>
                    </div>
                </div>

                <!-- Enhanced Address Details with Info-boxes -->
                <div class="card card-primary">
                    <div class="card-header bg-primary">
                        <h3 class="card-title text-white"><i class="fas fa-info-circle"></i> Contact Information</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="info-box mb-3 bg-primary">
                            <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Address</span>
                                <span class="info-box-number">{{ companySettings.address }}</span>
                            </div>
                        </div>
                        <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="fas fa-phone-volume"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Phone 1</span>
                                <span class="info-box-number">{{ companySettings.phone1 }}</span>
                            </div>
                        </div>
                        <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="fas fa-phone-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Phone 2</span>
                                <span class="info-box-number">{{ companySettings.phone2 }}</span>
                            </div>
                        </div>
                        <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="fas fa-globe-americas"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">City/State</span>
                                <span class="info-box-number">
                                    {{ companySettings.city }}, {{ companySettings.state }}
                                </span>
                            </div>
                        </div>
                        <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="fas fa-flag"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">County</span>
                                <span class="info-box-number">{{ companySettings.county }}</span>
                            </div>
                        </div>
                        <div class="info-box mb-3 bg-success">
                            <span class="info-box-icon"><i class="fas fa-globe"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Website</span>
                                <span class="info-box-number">{{ companySettings.website }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card card-primary card-outline"  v-if="authStore.hasRole(['Super Admn', 'Admin'])">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit"></i> Profile Setting</h3>
                    </div>
                    <div class="card-body">
                        <nav class="nav nav-pills flex-column flex-sm-row">
                            <a class="flex-sm-fill text-sm-center nav-link active" 
                               href="#profile-info" data-toggle="tab">
                                Profile Info
                            </a>
                            <a class="flex-sm-fill text-sm-center nav-link" 
                               href="#address-info" data-toggle="tab">
                                Address Info
                            </a>
                            <a class="flex-sm-fill text-sm-center nav-link" 
                               href="#email-setup-info" data-toggle="tab">
                                Mailer Setup Info
                            </a>
                            <a class="flex-sm-fill text-sm-center nav-link" 
                               href="#apis-info" data-toggle="tab">
                                Apis Info
                            </a>
                        </nav>
                        <div class="tab-content mt-2">
                            <!-- Profile Info Tab -->
                            <div class="tab-pane fade show active" id="profile-info" role="tabpanel">
                                <form @submit.prevent="onSubmit">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <FormUpload
                                                label="Upload Company Logo (no text)"
                                                name="logo"
                                                placeholder="Upload Company Logo (no text)"
                                                type="file"
                                                accept="image/*"
                                                @change="logoChangeImage($event)"
                                            />
                                            <div v-if="values.logo" class="mt-2">
                                                <img :src="updateLogoImage(values.logo)" 
                                                     alt="Profile Image" class="w-1/3 img-circle">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <FormUpload
                                                label="Upload Company Text Logo (no image)"
                                                name="textlogo"
                                                placeholder="Upload  Company Text Logo (no image)"
                                                type="file"
                                                class="col-md-6"
                                                accept="image/*"
                                                @change="textlogoChangeImage($event)"
                                            />
                                            <div v-if="values.textlogo" class="mt-2">
                                                <img :src="updateTextlogoImage(values.textlogo)" 
                                                     alt="Profile Image" class="w-1/3 img-circle">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <FormUpload
                                                label="Upload Company Iso logo"
                                                name="isologo"
                                                placeholder="Upload Company Iso logo"
                                                type="file"
                                                accept="image/*"
                                                @change="isoChangeImage($event)"
                                            />
                                            <div v-if="values.logo" class="mt-2">
                                                <img :src="updateIsoImage(values.isologo)" 
                                                     alt="Profile Image" class="w-1/3 img-circle">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <FormInput
                                            :labeled="true"
                                            label="Company Name"
                                            name="name"
                                            class="col-md-6 mb-2"
                                            placeholder="Enter Company Name"
                                            type="text"
                                        />
                                        <FormInput
                                            :labeled="true"
                                            label="Company Iso"
                                            name="iso"
                                            class="col-md-6 mb-2"
                                            placeholder="Enter Company Iso"
                                            type="text"
                                        />
                                        <FormTextBox
                                            label="About Company"
                                            name="about"
                                            class="col-md-12 mb-2"
                                            placeholder="Enter About Company"
                                        />
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-block mt-3">
                                                Update Company Info
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Address Info Tab -->
                            <div class="tab-pane fade" id="address-info" role="tabpanel">
                                <form @submit.prevent="onSubmit">
                                    <div class="row">
                                        <FormTextBox
                                            :labeled="true"
                                            label="Company Address"
                                            name="address"
                                            class="col-md-12 mb-2"
                                            placeholder="Enter Company Address"
                                        />
                                        <FormInput
                                            :labeled="true"
                                            label="County"
                                            name="county"
                                            placeholder="Enter Company County"
                                            class="col-md-4 mb-2"
                                            type="text"
                                        />
                                        <FormInput
                                            :labeled="true"
                                            label="City"
                                            name="city"
                                            placeholder="Enter Company City"
                                            class="col-md-4"
                                            type="text"
                                        />
                                        <FormInput
                                            :labeled="true"
                                            label="State"
                                            name="state"
                                            placeholder="Enter Company State"
                                            class="col-md-4 mb-2"
                                            type="text"
                                        />
                                        <FormInput
                                            :labeled="true"
                                            label="Company Phone 1"
                                            name="phone1"
                                            placeholder="Enter Company Phone 1"
                                            class="col-md-4 mb-2"
                                            type="number"
                                        />
                                        <FormInput
                                            :labeled="true"
                                            label="Company Phone 2"
                                            name="phone2"
                                            placeholder="Enter Company Phone 2"
                                            class="col-md-4 mb-2"
                                            type="number"
                                        />
                                        <FormInput
                                            :labeled="true"
                                            label="Company Website"
                                            name="website"
                                            placeholder="Enter Company Website"
                                            class="col-md-4 mb-2"
                                            type="text"
                                        />
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-block mt-3">
                                                Update Address Info
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Email Setup Info -->
                            <div class="tab-pane fade" id="email-setup-info" role="tabpanel">
                                <form @submit.prevent="onSubmit">
                                    <div class="row" v-if="mailTypeOptions">
                                        <div class="form-group col-md-4">
                                            <label class="text-bold font-medium tracking-wide">
                                                Mail Type
                                            </label>
                                            <div :class="[
                                                'multiselect-container text-danger',
                                                { error: !!errorMessagemailtype },
                                            ]">
                                                <Multiselect
                                                    id="mailtype"
                                                    v-model="selectedMailType"
                                                    mode="tags"
                                                    required
                                                    placeholder="Choose your stack"
                                                    :close-on-select="true"
                                                    :filter-results="false"
                                                    :min-chars="1"
                                                    :resolve-on-load="false"
                                                    :delay="0"
                                                    :searchable="true"
                                                    :canDeselect="true"
                                                    :options="mailTypeOptions"
                                                    :valueProp="'id'"
                                                    :trackBy="'id'"
                                                    :label="'name'"
                                                    class="col-span-3"
                                                    :classes="customClasses"
                                                    :object="true" 
                                                    @select="selectedmailtype($event)"
                                                    ref="multiselectComponent"
                                                />
                                                <div v-if="errorMessagemailtype" class="message text-danger"> 
                                                    {{ errorMessagemailtype }} 
                                                </div>                                        
                                            </div>
                                        </div>
                                        <div  v-for="(field, index) in values.mailtype.values" 
                                              :key="index"                                        
                                              class="col-md-4 mb-2">
                                            <FormInput 
                                                :labeled="true"
                                                :label="field.nameField"
                                                :name="'mailtype.values[' + index + '].valueName'"
                                                :placeholder="field.namePlaceholder"
                                                :type="getInputType(field.nameField)"
                                            /> 
                                        </div>
                                    </div>
                                    <div class="row">                                        
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-block mt-3">
                                                Update Email Settings
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- APIS Info -->
                            <div class="tab-pane fade" id="apis-info" role="tabpanel">
                                <form @submit.prevent="onSubmit">
                                    <div class="row">
                                        <FormTextBox
                                            label="Company PSPDFKIT licencekey"
                                            name="pspdkitlicencekey"
                                            class="col-md-12 mb-2"
                                            placeholder="Enter Company PSPDFKIT licencekey"
                                        />
                                    </div>
                                    <div class="row">                                        
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-block mt-3">
                                                Update APIs Settings
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Mail Settings Section -->
                <div class="card card-primary">
                    <div class="card-header bg-primary">
                        <h3 class="card-title text-white">Email Settings Overview</h3>
                    </div>
                    <div class="card-body bg-light">
                        <h4 class="text-center mb-4">
                            <i class="fas fa-envelope-open-text mr-2"></i>
                            Email Setup Details for 
                            <span class="font-bold text-primary">
                                {{ companySettings.mailtype.name.toUpperCase() }}
                            </span>
                        </h4>
                        <div class="row">
                            <div class="col-sm-6" 
                                 v-for="(value, index) in companySettings.mailtype.values" :key="index">
                                <div class="info-box" :class="getIconAndColor(value.nameField).color">
                                    <span class="info-box-icon">
                                        <i :class="getIconAndColor(value.nameField).icon"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ value.namePlaceholder }}</span>
                                        <span class="info-box-number">{{ value.valueName }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <strong class="d-block mb-2">
                                <i class="fas fa-certificate mr-2"></i>PSPDFKit Licence Key</strong>
                            <p class="badge badge-primary p-2 d-inline-block text-wrap" style="max-width: 100%;">
                                {{ companySettings.pspdkitlicencekey }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>
<style scoped>
.hide-icon {
  display: none !important;
}
.custom-tag-width {
  width: 80% !important;

  @media (max-width: 600px) {
    width: 100% !important; 
  }
}
</style>
