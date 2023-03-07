export default class Request {
    url: string;
    body: {[index: string]: any};

    constructor(url: string, body: {[index: string]: any}) {
        this.url = url;
        this.body = body;
    }
}