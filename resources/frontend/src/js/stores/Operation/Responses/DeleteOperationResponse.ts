export default class DeleteOperationResponse {
    private readonly _success: boolean;

    constructor(success: boolean) {
        this._success = success;
    }

    get success(): boolean {
        return this._success;
    }
}