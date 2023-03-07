export default class Operation {
    private _id: number;

    private _amount: number;

    private _date: Date;

    constructor(id: number, amount: number, date: Date) {
        this._id = id;
        this._amount = amount;
        this._date = date;
    }

    get id(): number {
        return this._id;
    }

    set id(value: number) {
        this._id = value;
    }

    get amount(): number {
        return this._amount;
    }

    set amount(value: number) {
        this._amount = value;
    }

    get date(): Date {
        return this._date;
    }

    set date(value: Date) {
        this._date = value;
    }
}