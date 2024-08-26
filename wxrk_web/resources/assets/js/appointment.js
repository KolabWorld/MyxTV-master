import {ZoomMtg, ZoomMtgLang} from "@zoomus/websdk";

ZoomMtg.setZoomJSLib('/vendor/zoomus/websdk', '/av');

ZoomMtg.preLoadWasm();
ZoomMtg.prepareJssdk();

ZoomMtg.setLogLevel('info');

window.ZoomMtg = ZoomMtg;