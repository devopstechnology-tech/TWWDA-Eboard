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
                <div class="card card-primary card-outline">
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
                                    <div class="row">
                                        <FormObjectSelect
                                            name="mailtype"
                                            label="Select Company Mailer"
                                            placeholder="Select Company Mailer"
                                            class="col-md-4 mb-2"
                                            :options="mailTypeOptions"
                                        />
                                        <div v-for="(field, index) in values.mailtype.values" 
                                             :key="index"                                        
                                             class="col-md-4 mb-2">
                                            <FormInput 
                                                :labeled="true"
                                                :label="field.nameField"                                                
                                                :name="'mailtype.values[' + index + '].valueName'"
                                                :placeholder="field.namePlaceholder"
                                                type="text"                                                     
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
                        <h4 class="text-center mb-4"><i class="fas fa-envelope-open-text mr-2"></i>Email Setup Details</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-mail-bulk"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Mailer</span>
                                        <span class="info-box-number">{{ companySettings.mailer }}</span>
                                    </div>
                                </div>
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-network-wired"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Mail Port</span>
                                        <span class="info-box-number">{{ companySettings.MAIL_PORT }}</span>
                                    </div>
                                </div>
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-user-shield"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Mail Username</span>
                                        <span class="info-box-number">{{ companySettings.MAIL_USERNAME }}</span>
                                    </div>
                                </div>
                                
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-at"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Mail From Address</span>
                                        <span class="info-box-number">{{ companySettings.MAIL_FROM_ADDRESS }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-server"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Mail Host</span>
                                        <span class="info-box-number">{{ companySettings.MAIL_HOST }}</span>
                                    </div>
                                </div>
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-lock"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Mail Encryption</span>
                                        <span class="info-box-number">{{ companySettings.MAIL_ENCRYPTION }}</span>
                                    </div>
                                </div>
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-key"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Mail Password</span>
                                        <span class="info-box-number">{{ companySettings.MAIL_PASSWORD }}</span>
                                    </div>
                                </div>
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-user-tag"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Mail From Name</span>
                                        <span class="info-box-number">{{ companySettings.MAIL_FROM_NAME }}</span>
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

<script lang="ts">
import Vue from 'vue';
const forceUpdate = () =>{
    if (companySettings.value !== null) {
        populateForm(companySettings.value);
    } else {
        // Handle the case where settings are null, possibly initialize form with defaults
        console.log('No settings available to populate the form.');
    }
};

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
    // setFieldValue('mailtype', mailTypeOptions.value[0]);
    forceUpdate();
};

// Computed property to automatically update when settingsStore changes
const companySettings = computed(() => settingsStore.settings);

const populateForm = (settings: Settings) => {
    Object.keys(settings).forEach((key) => {
        const valueKey = key as keyof typeof settings; // Type assertion
        setFieldValue(valueKey, settings[valueKey]);
    });    
};

// Function to find the first active mailtype
const findActiveMailType = (mailtypes: any[]) => {
    return mailtypes.find((mailtype: { active: string; }) => mailtype.active === 'active');
};

const updateFieldDetail = (index: string|number, newValue: any) => {
    // Deep clone the entire mailtype object
    const newMailType = JSON.parse(JSON.stringify(values.mailtype));
    newMailType.values[index].valueName = newValue;
    values.mailtype = newMailType; // Re-assign to trigger reactivity
};

export default Vue.extend({
    
})
</script>
