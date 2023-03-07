import {defineStore} from "pinia";
import Api from "../Api/Api";
import Request from "../Api/Request";
import CreateOperationRequest from "./Requests/CreateOperationRequest";
import CreateOperationResponse from "./Responses/CreateOperationResponse";
import GetOperationResponse from "./Responses/GetOperationResponse";
import DeleteOperationRequest from "./Requests/DeleteOperationRequest";
import DeleteOperationResponse from "./Responses/DeleteOperationResponse";
import Operation from "../../entities/Operation";
import GetOperationRequest from "./Requests/GetOperationRequest";
import GetOperationCountResponse from "./Responses/GetOperationCountResponse";

export const useOperationStore = defineStore('operationStore', {
    state() {
        return {
            api: new Api()
        }
    },

    actions: {
        async createOperation(request: CreateOperationRequest): Promise<CreateOperationResponse> {
            const apiRequest = new Request('/operation/create', {
                amount: request.amount,
                date: request.getFormatDate()
            });

            const response = await this.api.post(apiRequest);

            return new CreateOperationResponse(response.success, response.message ?? '');
        },

        async getOperations(request: GetOperationRequest): Promise<GetOperationResponse> {
            const apiRequest = new Request('/operation/list', {
                limit: request.limit,
                page: request.page
            });

            const response = await this.api.post(apiRequest);

            const items: Array<Operation> = [];

            response.items.forEach((item: { id: number; amount: number; transaction_date: string; }) => {
                items.push(new Operation(item.id, item.amount, new Date(item.transaction_date)));
            })

            return new GetOperationResponse(response.success, items);
        },

        async deleteOperation(request: DeleteOperationRequest): Promise<DeleteOperationResponse> {
            const apiRequest = new Request('/operation/delete',  {id: request.id});

            const response = await this.api.post(apiRequest);

            return new DeleteOperationResponse(response.success);
        },

        async getOperationCount(): Promise<GetOperationCountResponse> {
            const apiRequest = new Request('/operation/count', {});

            const response = await this.api.post(apiRequest);

            return new GetOperationCountResponse(response.success, response.count);
        }
    }
});