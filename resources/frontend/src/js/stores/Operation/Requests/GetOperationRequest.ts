export default class GetOperationRequest {
    private _limit: number;

    private _page: number;

    constructor(limit: number, page: number) {
        this._limit = limit;
        this._page = page;
    }

    get limit(): number {
        return this._limit;
    }

    get page(): number {
        return this._page;
    }
}