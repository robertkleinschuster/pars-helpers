export class AbstractEvent {

    constructor() {
        if (this.constructor === AbstractEvent) {
            throw new Error("Abstract classes can't be instantiated.");
        }
    }

    static get getType()
    {
        throw new Error('not implemented');
    }
}
