import axios from "axios";
import Request from "./Request";

export default class Api
{
    private readonly api: string;

    public constructor() {
        this.api = '/api/v1';
    }

    public async post(request: Request) {
        try {
            const result = await axios.post(this.api + request.url, request.body);

            return result.data;
        } catch (error: any) {
            throw error.response;
        }
    }
}