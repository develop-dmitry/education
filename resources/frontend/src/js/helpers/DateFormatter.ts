export default class DateFormatter {
    private monthList = [
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря'
    ];

    public displayDate(date: Date): string {
        const day = this.getDisplayDate(date.getDate());
        const month = this.getDisplayMonth(date.getMonth());
        const year = date.getFullYear();

        return `${day} ${month} ${year}`;
    }

    private getDisplayMonth(date: number): string {
        return this.monthList[date];
    }

    private getDisplayDate(date: number): string {
        if (date < 10) {
            return '0' + date;
        }

        return date.toString();
    }
}