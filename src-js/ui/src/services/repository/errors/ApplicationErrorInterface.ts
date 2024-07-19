export default interface ApplicationErrorInterface {
    status: number
    errors?: Record<string, Record<string, string>>
    message: string
}
