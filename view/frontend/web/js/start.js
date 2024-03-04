require([], function () {

    function aaa() {
        return '123';
    }

    setTimeout(function () {
        console.log("EEEEEEEEEEMy Custom Js Code: " + aaa());
    }, 5000);
});
