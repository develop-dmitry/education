export default class CreateOperationResponse {
    public readonly success: boolean;

    public readonly message: string;

    public constructor(success: boolean, message: string = '') {
        this.success = success;
        this.message = message;
    }
}