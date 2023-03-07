import Operation from "../../../entities/Operation";

export default class GetOperationResponse {
    private readonly _success: boolean;

    private readonly _items: Array<Operation>;

    constructor(success: boolean, items: Array<Operation>) {
        this._success = success;
        this._items = items;
    }

    get success(): boolean {
        return this._success;
    }

    get items(): Array<Operation> {
        return this._items;
    }
}