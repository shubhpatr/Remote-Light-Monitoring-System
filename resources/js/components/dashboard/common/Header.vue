<template>
    <v-app-bar
        :clipped-left="$vuetify.breakpoint.lgAndUp"
        app
        color="#1e2749"
        elevate-3
    >
        <v-app-bar-nav-icon
            @click="drawerTrigger"
            app
            color="white"
            style="margin-left:0px"
        >
            <v-icon v-if="this.drawer == true"> mdi-arrow-left</v-icon>
        </v-app-bar-nav-icon>
        <v-toolbar-side-icon> </v-toolbar-side-icon>

        <v-toolbar-title>
            <span
                class="hidden-sm-and-down"
                style="color:white; font-weight:normal; font-size:1.5rem; font-family: 'Lato', sans-serif; letter-spacing: 0.125em;"
                text-align:center
            >
                Remote Light Monitoring System
            </span>
        </v-toolbar-title>

        <div class="flex-grow-1"></div>
        <span
            class="hidden-sm-and-down"
            style="color: white;padding-right: 4px; text-transform: capitalize; "
            >{{ dataUser.name }}</span
        >
        <v-btn icon to="/dashboard">
            <v-icon color="white">mdi-home-outline</v-icon>
        </v-btn>

        <v-btn icon color="#2D2D2D" @click="logout" href="/logoutuser">
            <v-icon color="white">mdi-power</v-icon>
        </v-btn>
    </v-app-bar>
</template>

<script>
export default {
    props: {
        source: String,
        dataDay: Array,
        newData: {}
    },
    data: () => ({
        drawer: false,
        dialog: false,
        offset: true,
        dataUser: {},
        dataNotif: {},
        dataTask: {},
        sitename: [],
        liftname: [],
        myData: [],
        items: []
    }),
    created() {
        this.dataUser = this.$store.state.authUser;
        this.initialize();
    },
    watch: {
        dataDay() {
            if (this.dataDay) {
                this.getDaily(this.dataDay); //
            }
            this.Machinelist();
            var interval = setInterval(() => {
                if (this.dataDay) {
                    this.getLast(this.dataDay); //
                }
                this.Machinelist();
            }, 1000);
        },
        newData() {
            this.myData = [];
            this.myData = this.newData.data;

            this.sitelocation = this.myData.slice(-1)[0].site_location;
            this.liftname = this.myData.slice(-1)[0].lift_name;
        }
    },
    methods: {
        async getLast() {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/sensor/0"
                });
                this.newData = data;
                //end
            } catch (e) {}
        },
        Machinelist() {
            for (let i = 0; i < this.dataDay.length; i++) {
                this.items.push(this.dataDay[i].name);
            }
        },
        async initialize() {
            this.start();
            this.getLast();
            if (this.dataUser.userType == 1) {
                try {
                    let { data } = await axios({
                        method: "get",
                        url: "/app/getnotifa/" + this.dataUser.id
                    });
                    this.dataTask = data;
                } catch (e) {
                    this.fail();
                }
            } else if (this.dataUser.userType == 3) {
                try {
                    let { data } = await axios({
                        method: "get",
                        url: "/app/getnotifm" + this.dataUser.id
                    });
                    this.dataTask = data;
                } catch (e) {
                    this.fail();
                }
            }

            this.itemupdate();

            this.finish();
        },
        handleGoToMenu(d) {
            return d;
        },
        showChild(child) {
            return child;
        },

        itemupdate() {
            this.items = [];

            for (let i = 0; i < this.dataTask.data.length; i++) {
                this.items.push({
                    title: this.dataTask.data[i].task_name + " Completed",
                    icon: "mdi-wrench-outline",
                    id: this.dataTask.data[i].machine_id
                });
            }
        },
        logout() {
            if (confirm("Are you sure you want to Logout?") == true) {
                this.$router.push("/logoutuser");
            }
        },

        drawerTrigger() {
            this.drawer = !this.drawer;
            this.$emit("send", this.drawer);
        }
    }
};
</script>
<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Lato&display=swap");
</style>
