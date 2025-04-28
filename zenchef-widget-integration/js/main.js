(function (document, elementTagName, id) {
    const element = document.getElementsByTagName(elementTagName)[0];

    if (document.getElementById(id) || element.parentNode == null) {
        return;
    }

    var scriptElement = document.createElement(elementTagName);
    scriptElement.id = id;
    scriptElement.async = true;
    scriptElement.src = 'https://sdk.zenchef.com/v1/sdk.min.js';
    element.parentNode.insertBefore(scriptElement, element);
})(document, 'script', 'zenchef-sdk');
