export default class GetOperationCountResponse {
    private _success: boolean;

    private _count: number;

    constructor(success: boolean, count: number) {
        this._success = success;
        this._count = count;
    }

    get success(): boolean {
        return this._success;
    }

    get count(): number {
        return this._count;
    }
}