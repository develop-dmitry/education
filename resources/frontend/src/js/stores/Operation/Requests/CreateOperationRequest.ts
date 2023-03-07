export default class CreateOperationRequest {
    public readonly amount: number;

    public readonly date: Date;

    constructor(amount: number, date: Date) {
        this.amount = amount;
        this.date = date;
    }

    public getFormatDate(): string {
        let date: string = this.date.getFullYear() + '-';

        if (this.date.getMonth() < 10) {
            date += '0' + (this.date.getMonth() + 1) + '-';
        } else {
            date += this.date.getMonth() + '-';
        }

        if (this.date.getDate() < 10) {
            date += '0' + this.date.getDate();
        } else {
            date += this.date.getDate();
        }

        return date;
    }
}