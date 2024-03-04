require([], function () {

    function aaa() {
        return '123';
    }

    setTimeout(function () {
        console.log("EEEEE start once EEEEEMy Custom Js Code: " + aaa());
    }, 5000);
});
