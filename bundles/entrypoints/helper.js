import {ServerEventHelper} from "../js/ServerEventHelper/EventHelper";
window.eventHelper = new ServerEventHelper(document);

document.addEventListener("DOMContentLoaded", () => {
    window.eventHelper.init();
});
