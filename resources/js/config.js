/*module.exports = {
    ASSET_URL_PREFIX: '/project/shopify/BasicSetup/',
    BASE_URL: (window.location.origin) + '/project/shopify/BasicSetup/',
    API_URL: (window.location.origin) + '/project/shopify/BasicSetup/api/',
    API_AUTH_URL: (window.location.origin) + '/project/shopify/BasicSetup/auth/',
    URL_PREFIX: '/project/shopify/BasicSetup/',
    APP_NAME: 'MyLaravelApp'
}*/

var BASE_URL = process.env.MIX_VUE_BASE_URL;
if((BASE_URL.endsWith('/')) === false) {
    BASE_URL+='/';
}
var ASSET_URL = process.env.MIX_VUE_ASSET_URL;
if((ASSET_URL.endsWith('/')) === false) {
    ASSET_URL+='/';
}
module.exports = {
    BASE_URL: BASE_URL,
    ASSET_URL : ASSET_URL,
    API_URL: BASE_URL + 'api/',
    API_AUTH_URL: BASE_URL + 'auth/',
    APP_NAME: (process.env.MIX_VUE_APP_NAME),
    NAME_PREFIX: (process.env.MIX_NAME_PREFIX),
    URL_PREFIX: (process.env.MIX_VUE_URL_PREFIX),
}