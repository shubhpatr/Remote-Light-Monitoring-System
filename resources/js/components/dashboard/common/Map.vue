<template>
    <div>
        <!-- <h1>Your Coordinates</h1> -->
        <p><strong>Latitude: </strong>{{ coordinates.lat }}</p>
        <p><strong>Longitude: </strong>{{ coordinates.lng }}</p>

        <GmapMap
            :center="coordinates"
            :zoom="12"
            :options="{
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: true,
                streetViewControl: false,
                rotateControl: false,
                fullscreenControl: true,
                disableDefaultUi: false
            }"
            map-type-id="terrain"
            style=" height: 18rem"
        >
            >
            <GmapMarker :position="coordinates" />
        </GmapMap>
    </div>
</template>
<script>
// import * as VueGoogleMaps from 'vue2-google-maps';

// Vue.use(VueGoogleMaps, {
//   load: {
//     key: '',
//     libraries: 'places', // This is required if you use the Autocomplete plugin
//     // OR: libraries: 'places,drawing'
//     // OR: libraries: 'places,drawing,visualization'
//     // (as you require)

//     //// If you want to set the version, you can do so:
//     // v: '3.26',
//   },});

export default {
    data() {
        return {
            coordinates: {
                lat: 28.6585,
                lng: 77.2127
            }
        };
    },

    created() {
        this.getLongLat();
    },

    methods: {
        async getLongLat() {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/getlonglat/" + this.$route.params.id
                });
                this.coordinates = data;

                //end
            } catch (e) {}
        }
    }
};
</script>
