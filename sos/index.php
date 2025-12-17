<style>
    #sos_button {
        padding: 10px 25px;
        background: red;
        color: white;
        border-radius: 50px;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        position: fixed;
        bottom: 20px;
        right: 20px;
        border:none;
    }


    #what_is_emergency {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        translate: -50% -50%;
        background: #b71010;
        color: white;
        padding: 30px 40px;
        border-radius: 12px;
        font-size: 25px;
        z-index: 5000;
        text-align: center;
    }

    #what_is_emergency .actions {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 20px;
    }

    #what_is_emergency .actions button {
        padding: 15px;
        font-size: 22px;
        border: none;
        border-radius: 50px;
        color: black;
        background: white;
        cursor: pointer;
        font-weight: bold;
    }

    #emergency_wrapper {
        display: none;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 4999;
        background: #000000cf;
    }
</style>

<button id="sos_button" onclick="emit_sos()">SOS</button>

<div id="emergency_wrapper"></div>

<div id="what_is_emergency">
    <h2>What do you need?</h2>
    <div class="actions">
        <button onclick="search_nearest(this,'hospital')">Nearest Hospital</button>
        <button onclick="call_sos('100')">Call Help</button>
        <button onclick="cancel_sos()">Cancel</button>
    </div>
</div>

<script>
    let what_is_emergency = document.getElementById("what_is_emergency");
    let emergency_wrapper = document.getElementById("emergency_wrapper");

    function emit_sos() {
        what_is_emergency.style.display = 'block';
        emergency_wrapper.style.display = 'block';
    }

    function cancel_sos() {
        what_is_emergency.style.display = 'none';
        emergency_wrapper.style.display = 'none';
    }

    function call_sos(number) {
        location.href = `tel:${number}`;
    }

    function search_nearest(ele, place) {
        let originalText = ele.textContent;
        ele.textContent = 'Getting your location...';
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                let coords = pos.coords;
                ele.textContent = originalText;
                cancel_sos();
                location.href = `/ecotrail/sos/sos.php?s=${place}&lat=${coords.latitude}&lon=${coords.longitude}&accuracy=${coords.accuracy}`;
            },
            (err) => {
                console.error(err);
                ele.textContent = 'Failed to get location';
            },
            { enableHighAccuracy: true, maximumAge: 0 }
        );
    }
</script>
