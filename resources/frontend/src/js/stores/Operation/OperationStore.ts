import {defineStore} from "pinia";
import Api from "../Api/Api";
import Request from "../Api/Request";
import CreateOperationRequest from "./Requests/CreateOperationRequest";
import CreateOperationResponse from "./Responses/CreateOperationResponse";
import GetOperationResponse from "./Responses/GetOperationResponse";
import DeleteOperationRequest from "./Requests/DeleteOperationRequest";
import DeleteOperationResponse from "./Responses/DeleteOperationResponse";
import Operation from "../../entities/Operation";

export const useOperationStore = defineStore('operationStore', {
    state() {
        return {
            api: new Api()
        }
    },

    actions: {
        async createOperation(request: CreateOperationRequest): Promise<CreateOperationResponse> {
            const body = {
                amount: request.amount,
                date: request.getFormatDate()
            }

            const apiRequest = new Request('/operation/create', body);

            const response = await this.api.post(apiRequest);

            return new CreateOperationResponse(response.success, response.message ?? '');
        },

        async getOperations(): Promise<GetOperationResponse> {
            const apiRequest = new Request('/operation/list', {});

            const response = await this.api.post(apiRequest);

            const items: Array<Operation> = [];

            response.items.forEach((item: { id: number; amount: number; transaction_date: string; }) => {
                items.push(new Operation(item.id, item.amount, new Date(item.transaction_date)));
            })

            return new GetOperationResponse(response.success, items);
        },

        async deleteOperation(request: DeleteOperationRequest): Promise<DeleteOperationResponse> {
            const body = {id: request.id};
            const apiRequest = new Request('/operation/delete', body);

            const response = await this.api.post(apiRequest);

            return new DeleteOperationResponse(response.success);
        }
    }
});