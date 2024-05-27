

import {differenceInDays, differenceInHours, differenceInMonths, differenceInYears, formatDistanceToNow,parseISO} from 'date-fns';
import {formatInTimeZone} from 'date-fns-tz';
import {ref} from 'vue';
// Define a ref for the custom title
export const customTitle = ref('');

function capitalizeWords(input: string): string {
    return input.replace(/\b\w/g, (char) => char.toUpperCase());
}
// Function to update the breadcrumb title
export function updateBreadcrumbCustomTitle(title: string) {
    customTitle.value = capitalizeWords(title);
}

export function truncateDescription(description: string, maxLength: number): string {
    return description?.length > maxLength ? description.substring(0, maxLength) + '...' : description;
}


export const iconTypes = [
    {name: 'fa-edit', value: 'far fa-edit'},
    {name: 'fa-star', value: 'far fa-star'},
    {name: 'fa-eye', value: 'far fa-eye'},
    {name: 'fa-trash-alt', value: 'far fa-trash-alt'},
    {name: 'fa-check-circle', value: 'far fa-check-circle'},
    {name: 'fa-times-circle', value: 'far fa-times-circle'},
    {name: 'fa-envelope', value: 'far fa-envelope'},
    {name: 'fa-comments', value: 'far fa-comments'},
    {name: 'fa-heart', value: 'far fa-heart'},
    {name: 'fa-share-square', value: 'far fa-share-square'},
    {name: 'fa-bookmark', value: 'far fa-bookmark'},
    {name: 'fa-calendar-alt', value: 'far fa-calendar-alt'},
    {name: 'fa-copy', value: 'far fa-copy'},
    {name: 'fa-folder', value: 'far fa-folder'},
    {name: 'fa-paper-plane', value: 'far fa-paper-plane'},
    {name: 'fa-clipboard', value: 'far fa-clipboard'},
    {name: 'fa-clock', value: 'far fa-clock'},
    {name: 'fa-bell', value: 'far fa-bell'},
    {name: 'fa-flag', value: 'far fa-flag'},
    {name: 'fa-life-ring', value: 'far fa-life-ring'},
];
export const supportedImageTypes = [
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',
    'image/svg+xml',
    'image/bmp',
    'image/tiff',
];

export const supportedFileTypes = [
    'application/pdf',             // PDFs
    'application/msword',          // Microsoft Word (DOC)
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Microsoft Word (DOCX)
    'application/vnd.ms-excel',    // Microsoft Excel (XLS)
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // Microsoft Excel (XLSX)
    'text/plain',                  // Plain text files
    'application/rtf',             // Rich Text Format
    'application/vnd.ms-powerpoint',   // Microsoft PowerPoint (PPT)
    'application/vnd.openxmlformats-officedocument.presentationml.presentation', // Microsoft PowerPoint (PPTX)
];
export const mimmes = [
    {mime: 'application/pdf', extension: 'pdf'},
    {mime: 'application/msword', extension: 'doc'},
    {mime: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', extension: 'docx'},
    {mime: 'application/vnd.ms-excel', extension: 'xls'},
    {mime: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', extension: 'xlsx'},
    {mime: 'text/plain', extension: 'txt'},
    {mime: 'application/rtf', extension: 'rtf'},
    {mime: 'application/vnd.ms-powerpoint', extension: 'ppt'},
    {mime: 'application/vnd.openxmlformats-officedocument.presentationml.presentation', extension: 'pptx'},
];

export const getIconAndColor = (field) => {
    const icons = {
        MAIL_HOST: {icon: 'fas fa-server', color: 'bg-success'},
        MAIL_PORT: {icon: 'fas fa-network-wired', color: 'bg-info'},
        MAIL_USERNAME: {icon: 'fas fa-user-shield', color: 'bg-warning'},
        MAIL_PASSWORD: {icon: 'fas fa-key', color: 'bg-danger'},
        MAIL_ENCRYPTION: {icon: 'fas fa-lock', color: 'bg-primary'},
        MAILGUN_DOMAIN: {icon: 'fas fa-globe', color: 'bg-secondary'},
        MAILGUN_SECRET: {icon: 'fas fa-user-secret', color: 'bg-dark'},
        SES_KEY: {icon: 'fas fa-id-card', color: 'bg-warning'},
        SES_SECRET: {icon: 'fas fa-user-secret', color: 'bg-danger'},
        SES_REGION: {icon: 'fas fa-map-marker-alt', color: 'bg-info'},
        POSTMARK_TOKEN: {icon: 'fas fa-envelope', color: 'bg-primary'},
    };
    return icons[field] || {icon: 'fas fa-envelope-open', color: 'bg-light'}; // Default
};
export const getInputType = (fieldName)=>{
    const typeMapping = {
        'MAIL_HOST': 'text',
        'MAIL_PORT': 'number',
        'MAIL_USERNAME': 'email',
        'MAIL_PASSWORD': 'password',
        'MAIL_FROM_ADDRESS': 'email',
        'MAIL_FROM_NAME': 'text',
        'MAIL_ENCRYPTION': 'text',
        // Add other mappings as necessary
    };
    return typeMapping[fieldName] || 'text';
};
  
export function getFileExtensionByMimeType(mimeType: string) {
    const  supportedFileType = mimmes.find(fileType => fileType.mime === mimeType);
    if(supportedFileType){
        return `/img/svg/${supportedFileType.extension+'.svg'}`;
    }
}

export const fileDetails = ref({
    name: '',
    size: '',
    type: '',
    formatFileSize: '',
    previewUrl: '',
    lastModifiedDate: '',
});
export const resetfileDetails = ()=>{
    fileDetails.value.name = '';
    fileDetails.value.size = '';
    fileDetails.value.type = '';
    fileDetails.value.formatFileSize = '';
    fileDetails.value.previewUrl = '';
};
export function formatFileSize(bytes: number) {
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes === 0) return '0 Byte';
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(k)));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
export function setfileDetails (media: { name: string | null; size: string | null; id: string | null; created_at: string | null; collection_name: string | null; conversions_disk: string | null; custom_properties: string[] | null; deleted_at: string | null; disk: string | null; file_name: string | null; generated_conversions: string[] | null; manipulations: string[] | null; mime_type: string | null; model_id: string | null; model_type: string | null; order_column: string | null; original_url: string | null; preview_url: string | null; responsive_images: string[] | null; updated_at: string | null; uuid: string | null; }){
    // console.log('media', media);
    const name = media.file_name.split('.').pop().toLowerCase()+'.svg';
    fileDetails.value.name = media.file_name;
    fileDetails.value.size = media.size;
    fileDetails.value.type = media.mime_type;
    fileDetails.value.lastModifiedDate = media.updated_at;
    fileDetails.value.previewUrl = `/img/svg/${name}`;
};

//coverimage
// images loading & updating & changing
const newCoverImage = ref('');//loading coverimage
export const coverChangeImage = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (!input.files?.length) return;
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = (event) => {
        const result = event.target?.result as string;
        newCoverImage.value = result;
    };
    reader.onerror = (error) => {
        console.error('File read error:', error);
    };
    reader.readAsDataURL(file); // This will trigger reader.onload with the file's data URL as result
};
export const updateCoverImage = (cover_image: string | undefined) => {
    const img = newCoverImage.value;
    if (img === null){
        return null;
    } else {
        if (img.length > 100) {
            return newCoverImage.value;
        } else {
            if (cover_image) {
                return `/images/cover/${cover_image}`;
            } else {
                return null;
            }
        }
    }
};
export function resetCoverImage() {
    newCoverImage.value = '';
}

const newIcon = ref('');//loading coverimage
export const coverChangeIcon = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (!input.files?.length) return;
    const file = input.files[0];
    const name = file?.name.split('.').pop().toLowerCase()+'.svg';
    // console.group(file);
    fileDetails.value.name = file?.name;
    fileDetails.value.size = file?.size;
    fileDetails.value.type = file?.type;
    fileDetails.value.lastModifiedDate = file?.lastModifiedDate;
    fileDetails.value.previewUrl =  `/img/svg/${name}`;
    const reader = new FileReader();
    reader.onload = (event) => {
        const result = event.target?.result as string;
        newIcon.value = result;
    };
    reader.onerror = (error) => {
        console.error('File read error:', error);
    };
    reader.readAsDataURL(file); // This will trigger reader.onload with the file's data URL as result
};

//icon
const newIconImage = ref('');//loading coverimage
export const iconChangeImage = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (!input.files?.length) return;
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = (event) => {
        const result = event.target?.result as string;
        newIconImage.value = result;
    };
    reader.onerror = (error) => {
        console.error('File read error:', error);
    };
    reader.readAsDataURL(file); // This will trigger reader.onload with the file's data URL as result
};
export const updateIconImage = (icon: string | undefined) => {
    const img = newIconImage.value;
    if (img === null){
        return null;
    } else {
        if (img.length > 100) {
            return newIconImage.value;
        } else {
            if (icon) {
                return `/images/icon/${icon}`;
            } else {
                return null;
            }
        }
    }
};
export function resetIconImage() {
    newIconImage.value = '';
}

//profile
const newProfileImage = ref('');//loading profileimage
export const profileChangeImage = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (!input.files?.length) return;
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = (event) => {
        const result = event.target?.result as string;
        newProfileImage.value = result;
    };
    reader.onerror = (error) => {
        console.error('File read error:', error);
    };
    reader.readAsDataURL(file); // This will trigger reader.onload with the file's data URL as result
};
export const updateProfileImage = (profile_image: string | undefined) => {
    const img = newProfileImage.value;
    if (img === null){
        return null;
    } else {
        if (img.length > 100) {
            return newProfileImage.value;
        } else {
            if (profile_image) {
                return `/images/avatar/${profile_image}`;
            } else {
                return null;
            }
        }
    }
};

export function resetProfileImage() {
    newProfileImage.value = '';
}

//logo
const newLogoImage = ref('');//loading logoimage
export const logoChangeImage = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (!input.files?.length) return;
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = (event) => {
        const result = event.target?.result as string;
        newLogoImage.value = result;
    };
    reader.onerror = (error) => {
        console.error('File read error:', error);
    };
    reader.readAsDataURL(file); // This will trigger reader.onload with the file's data URL as result
};
export const updateLogoImage = (logo_image: string | undefined) => {
    const img = newLogoImage.value;
    if (img === null){
        return null;
    } else {
        if (img.length > 100) {
            return newLogoImage.value;
        } else {
            if (logo_image) {
                return `/images/logo/${logo_image}`;
            } else {
                return null;
            }
        }
    }
};

export function resetLogoImage() {
    newLogoImage.value = '';
}
//textlogo
const newTextlogoImage = ref('');//loading textlogoimage
export const textlogoChangeImage = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (!input.files?.length) return;
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = (event) => {
        const result = event.target?.result as string;
        newTextlogoImage.value = result;
    };
    reader.onerror = (error) => {
        console.error('File read error:', error);
    };
    reader.readAsDataURL(file); // This will trigger reader.onload with the file's data URL as result
};
export const updateTextlogoImage = (textlogo_image: string | undefined) => {
    const img = newTextlogoImage.value;
    if (img === null){
        return null;
    } else {
        if (img.length > 100) {
            return newTextlogoImage.value;
        } else {
            if (textlogo_image) {
                return `/images/textlogo/${textlogo_image}`;
            } else {
                return null;
            }
        }
    }
};

export function resetTextlogoImage() {
    newTextlogoImage.value = '';
}

//iso logo
const newIsoImage = ref('');//loading isoimage
export const isoChangeImage = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (!input.files?.length) return;
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = (event) => {
        const result = event.target?.result as string;
        newIsoImage.value = result;
    };
    reader.onerror = (error) => {
        console.error('File read error:', error);
    };
    reader.readAsDataURL(file); // This will trigger reader.onload with the file's data URL as result
};
export const updateIsoImage = (iso_image: string | undefined) => {
    const img = newIsoImage.value;
    if (img === null){
        return null;
    } else {
        if (img.length > 100) {
            return newIsoImage.value;
        } else {
            if (iso_image) {
                return `/images/iso/${iso_image}`;
            } else {
                return null;
            }
        }
    }
};

export function resetIsoImage() {
    newIsoImage.value = '';
}



export function loadCover(cover_image: string | undefined): string {
    if (cover_image) {
        return `/images/cover/${cover_image}`;
    } else {
        return '/img/bg.png';
    }
}
export function loadIcon (icon: string | undefined){
    if (icon) {
        return `/images/icon/${icon}`;
    } else{
        return '/img/bg.png'; 
    }   
}
export function loadAvatar(avatar_image: string | undefined): string {
    if (avatar_image) {
        return `/images/avatar/${avatar_image}`;
    } else {
        return 'img/user.jpg';
    }
}
export function loadLogo(logo: string | undefined): string {
    if (logo) {
        return `/images/logo/${logo}`;
    } else {
        return 'img/defaultlogo1.png';
    }
}
export function loadTextlogo(textlogo: string | undefined): string {
    if (textlogo) {
        return `/images/textlogo/${textlogo}`;
    } else {
        return 'img/defaulttextlogo1.png';
    }
}


export function loadIsologo(iso: string | undefined): string {
    if (iso) {
        return `/images/iso/${iso}`;
    } else {
        return 'img/defaultiso1.png';
    }
}


export function loadDefaultCover (cover_image: string | undefined){
    if (cover_image) {
        return `/img/${cover_image}`;
    } else {
        return '/img/bg.png';
    }
}
export function loadDefaultUserIcon (icon: string | undefined){
    if (icon) {
        return `/img/${icon}`;
    } else {
        return 'img/user.jpg';
    }
}
export function loadDefaultFolderSvg (image: string | undefined){
    if (image) {
        return `/img/svg/${image}`;
    } else {
        return '/img/svg/folder.svg';
    }
}
export function loadDefaultFileSvg (image: string | undefined){
    if (image) {
        return `/img/svg/${image}`;
    } else {
        return '/img/svg/folder.svg';
    }
}
export function loadDefaultThumbPng (image: string | undefined){
    if (image) {
        return `/img/${image}`;
    } else {
        return '/img/file.png';
    }

}






export const test = ref(['month', 'year', 'calendar']);

export  function formatDuration(duration: string) {
    if (duration !== null && duration !== undefined && duration !== '' && duration !== 0) {
        return `${duration} minutes`;
    }
    return ''; // Return empty string if duration is considered empty
}

// Use a computed property to format the date


export function formattedDate(isoDate: string, timezone: string) {
    const formatString = 'hh:mma'; // Simplified for "10:30PM" format

    try {
        const formatted = formatInTimeZone(isoDate, timezone, formatString);
        return formatted;
    } catch (error) {
        // console.error('Error formatting date:', error);
        return '';
    };
}
export function formattedDateTime(isoDate: string, timezone: string) {
    const formatString = 'EEE, d MMMM, yyyy, h:mma'; // Adjusted format

    try {
        const formatted = formatInTimeZone(isoDate, timezone, formatString);
        return formatted;
    } catch (error) {
        // Logging the error can help in debugging but is commented out here
        // console.error('Error formatting date:', error);
        return '';
    }
}


export function getAlphabet(index: number): string {
    return String.fromCharCode(97 + index);// ASCII 'a' is 97, 65 is A
};
export function getNumbering(index: number): string {
    return (index + 1).toString(); // Convert the number to string for consistency in return type
}

/**
 * Capitalizes the first letter of each word in a string.
 * @param {string} title - The string to capitalize.
 * @returns {string} The capitalized string.
 */
function capitalizeTitle(title: string): string {
    return title.replace(/\b(\w)/g, char => char.toUpperCase());
}


export const formatAgendaEntry = (parentIndex: number, childIndex = null) => {
    if (childIndex !== null) {
        return `${parentIndex + 1}.${childIndex + 1}`;
    }
    return `${parentIndex + 1}`;
};
export function formatMinuteEntry(order: any, title: string, day: any, month: any, year: any, childOrder: any) {
    const today = new Date();
    // Use current day/month/year if not provided
    const formattedDay = (day ?? today.getDate()).toString().padStart(2, '0');
    const formattedMonth = ((month ?? today.getMonth() + 1)).toString().padStart(2, '0'); // Month is 0-indexed
    const formattedYear = (year ?? today.getFullYear()).toString().substr(-2); // Get the last two digits of the year

    const capitalizedTitle = capitalizeTitle(title);

    // Construct the minute label with or without child order
    const minuteLabel = `MIN ${order}${childOrder ? `.${childOrder}` : ''}`;

    return `${minuteLabel}/${formattedDay}/${formattedMonth}/${formattedYear}: ${capitalizedTitle}`;
}

export function formatDate(dateStr: string): string {
    const date = new Date(dateStr);
    const options: Intl.DateTimeFormatOptions = {day: 'numeric', month: 'long', year: 'numeric'};
    let formattedDate = date.toLocaleDateString('en-US', options);

    // Add suffix for day
    const day = date.getDate();
    formattedDate = formattedDate.replace(day.toString(), getDayWithSuffix(day));

    return formattedDate;
}

// Helper function to add the correct suffix to the day
function getDayWithSuffix(day: number): string {
    if (day > 3 && day < 21) return day + 'th';
    switch (day % 10) {
        case 1:  return day + 'st';
        case 2:  return day + 'nd';
        case 3:  return day + 'rd';
        default: return day + 'th';
    }
}

// Function to format time from a full datetime string
export function formatTime(datetimeStr: string): string {
    const date = new Date(datetimeStr);
    const options: Intl.DateTimeFormatOptions = {hour: 'numeric', minute: 'numeric', hour12: true, timeZone: 'UTC'};
    return date.toLocaleTimeString('en-US', options);
}

export function formatTimeAgo(isoDate: string): string {
    try {
        const date = parseISO(isoDate);
        return formatDistanceToNow(date, {addSuffix: true});
    } catch (error) {
        console.error('Error formatting time ago:', error);
        return '';
    }
}

// Function to calculate duration based on the unit provided
export function calculateDuration(startDate: string, endDate: string, unit: 'days' | 'months' | 'years' | 'hours') {
    const start = parseISO(startDate);
    const end = parseISO(endDate);
    switch (unit) {
        case 'days':
            return `${differenceInDays(end, start)} days`;
        case 'months':
            return `${differenceInMonths(end, start)} months`;
        case 'years':
            return `${differenceInYears(end, start)} years`;
        case 'hours':
            return `${differenceInHours(end, start)} hours`;
        default:
            return '';
    }
}

// Function to format dates as 'x days/months/years ago' or 'in x days/months/years'
export function formatDateAgo(dateString: string) {
    const date = parseISO(dateString);
    return formatDistanceToNow(date, {addSuffix: true});
}

// Combined function to get both duration and formatted 'ago' string
export function getDuration(startDate: string, endDate: string, unit: 'days' | 'months' | 'years' | 'hours') {
    const duration = calculateDuration(startDate, endDate, unit);
    return duration;
}
export function FormattedAgo(startDate: string, endDate: string, unit: 'days' | 'months' | 'years' | 'hours') {
    const formattedAgo = formatDateAgo(endDate);
    return formattedAgo;
}


/**
 * Extracts the month in uppercase abbreviated form from a date string.
 * @param dateString The input date string in format "YYYY-MM-DD HH:MM:SS".
 * @returns The abbreviated month in uppercase (e.g., 'JAN', 'FEB').
 */
export function getYearFromDate(dateString: string): string {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {year: 'numeric'}).format(date);
}
export function getMonthAbbreviation(dateString: string): string {
    const date = new Date(dateString);
    return new Intl.DateTimeFormat('en-US', {month: 'short'}).format(date).toUpperCase();
}
  
/**
   * Extracts the day from a date string.
   * @param dateString The input date string in format "YYYY-MM-DD HH:MM:SS".
   * @returns The day as a string.
   */
export function getDayFromDate(dateString: string): string {
    const date = new Date(dateString);
    return date.getDate().toString();  // Convert day to string for consistency
}
// moneyFormatter.ts

/**
 * Formats a number or string to a specified format with a custom prefix.
 * If the currency symbol is not provided or is empty, defaults to 'USD'.
 * @param input The input value to format.
 * @param currency The custom currency symbol to use (defaults to '$').
 * @returns A formatted string with the custom currency symbol.
 */
export function formatMoney(money:number | string, currency:string ): string {
    const numericValue = Number(money);
  
    // Validate the numeric value
    if (isNaN(numericValue)) {
        return 'Invalid input';
    }
    // If currency is undefined or empty, set a default value
    if (!currency) {
        currency = '$';
    }
  
    // Define formatting options
    const options: Intl.NumberFormatOptions = {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    };
  
    // Create a formatter for the specified locale
    const formatter = new Intl.NumberFormat('en-US', options);
  
    // Format the number and prepend the currency symbol
    return `${currency} ${formatter.format(numericValue)}`;
}
  