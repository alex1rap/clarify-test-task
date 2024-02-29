export default class Api {

    static PREFIX = '/api';

    static async getCarriers() {
        return await fetch(`${this.PREFIX}/carriers`).then(res => res.json());
    }

    static async getCarrier(id) {
        return await fetch(`${this.PREFIX}/carriers/${id}`).then(res => res.json());
    }

    static async createCarrier(carrier) {
        return await fetch('${this.PREFIX}/carriers', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(carrier),
        }).then(res => res.json());
    }

    static async updateCarrier(carrier) {
        return await fetch(`${this.PREFIX}/carriers/${carrier.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(carrier),
        }).then(res => res.json());
    }

    static async deleteCarrier(carrier) {
        return await fetch(`${this.PREFIX}/carriers/${carrier.id}`, {
            method: 'DELETE',
        }).then(res => res.json());
    }

    static async getDeliveryCost(carrier, weight) {
        return await fetch(`${this.PREFIX}/carriers/${carrier.id}/delivery-cost`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({weight}),
        }).then(res => res.json());
    }

    static async parseTextTags(text) {
        return await fetch(`${this.PREFIX}/text/tags`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({text}),
        }).then(res => res.json());
    }

    static async parseTextKeys(text) {
        return await fetch(`${this.PREFIX}/text/keys`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({text}),
        }).then(res => res.json());
    }
}