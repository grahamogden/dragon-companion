export default interface ValidationError {
    minLength?: string
    _empty?: string
    maxLength?: string
    numeric?: string
    integer?: string
    naturalNumber?: string
    range?: string
    greaterThan?: string
    greaterThanOrEqual?: string
    lessThan?: string
    lessThanOrEqual?: string
    date?: string
    time?: string
    dateTime?: string
    localizedTime?: string
    uploadedFile?: string
    fileSize?: string
    mimeType?: string
    fileExtension?: string
    email?: string
    url?: string
    ip?: string
    creditCard?: string
    uuid?: string
    inList?: string
    regex?: string
    custom?: string
}