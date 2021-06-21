<template>
    <div>
        <v-navigation-drawer
            v-model="trigger"
            :clipped="$vuetify.breakpoint.lgAndUp"
            app
            style=" width: 350px;"
        >
            <v-list dense>
                <template v-for="(item, index) in items">
                    <v-row
                        v-if="item.heading"
                        :key="item.heading"
                        style="margin-right: 0px;"
                        align="left"
                    >
                        <v-col cols="6">
                            <v-subheader v-if="item.heading">{{
                                item.heading
                            }}</v-subheader>
                        </v-col>
                        <v-col cols="6" class="text-left">
                            <a href="#!" class="body-2 white--text">EDIT</a>
                        </v-col>
                    </v-row>
                    <v-list-group
                        v-else-if="item.children"
                        :key="index"
                        v-model="item.model"
                        :prepend-icon="
                            item.model ? item.icon : item['icon-alt']
                        "
                        append-icon
                        style="margin-right: 0px;"
                        v-show="handleGoToMenus(item)"
                        active-class=""
                    >
                        <template v-slot:activator>
                            <v-list-item style="margin-right: 0px;">
                                <v-list-item-content>
                                    <v-list-item-title>{{
                                        item.text
                                    }}</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </template>
                        <v-list-item
                            v-for="(child, i) in item.children"
                            :key="i"
                            :to="handleGoToMenu('/dashboard/' + child.link)"
                            v-show="showChild(child)"
                            style="margin-right: 0px;"
                        >
                            <v-flex style="display: flex;  ">
                                <v-list-item-action
                                    v-if="child.icon"
                                    style="margin-right: 20px;"
                                >
                                    <v-icon>{{ child.icon }} </v-icon>
                                </v-list-item-action>

                                <v-list-item-content>
                                    <v-list-item-title>
                                        {{ child.text }}
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-flex>
                        </v-list-item>
                    </v-list-group>
                    <v-list-item
                        v-else
                        :key="item.text"
                        style="margin-right: 0px;"
                    >
                        <v-list-item-action>
                            <v-icon>{{ item.icon }} </v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title
                                >{{ item.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                </template>
            </v-list>
            <template v-slot:append> </template>
        </v-navigation-drawer>
        <v-footer app style="background: #1e2749; justify-content: center;">
            <div class="opencolor">
                Created by
                <a
                    href="https://www.linkedin.com/in/divjeet-singh/"
                    target="_blank"
                >
                    Divjeet
                </a>
                &
                <a
                    href="https://www.linkedin.com/in/shubhammohapatra/"
                    target="_blank"
                >
                    Shubham
                </a>
            </div>
        </v-footer>
    </div>
</template>

<script>
export default {
    props: {
        trigger: true
    },
    data: () => ({
        drawer: null,
        userType: null,
        dataUser: [],
        i: 0,
        items: [
            {
                icon: "keyboard_arrow_down",
                "icon-alt": "mdi-monitor-dashboard",
                text: "Dashboard",
                model: false,
                parentAllowed: "",
                children: [
                    {
                        text: "View Dashboards",
                        link: "",
                        icon: "mdi-monitor-dashboard"
                    }
                ]
            }
        ]
    }),
    created() {
        this.userType = this.$store.state.authUser.id;
        this.initialize();
        // this.$vuetify.theme.dark = true;
        this.$vuetify.theme.themes.dark.primary = "#cc0000";
        this.$vuetify.theme.themes.light.primary = "#4C4C4C";
    },
    methods: {
        async initialize() {
            try {
                let { data } = await axios({
                    method: "get",
                    url: "/app/getuserpages/" + this.userType
                });
                this.dataUser = data;
                this.items[0].parentAllowed = this.dataUser.production_overview;
                this.items[1].parentAllowed = this.dataUser.manage_user;
                this.items[2].parentAllowed = this.dataUser.checklist_or_create;
                this.items[3].parentAllowed = this.dataUser.scan_or_document;
                this.items[4].parentAllowed = this.dataUser.setting;
            } catch (e) {}
        },
        handleGoToMenu(d) {
            return d;
        },
        handleGoToMenus(item) {
            if (item.parentAllowed == 1) {
                return true;
            }
            return false;
        },
        showChild(child) {
            return child;
        }
    }
};
</script>
<style scoped>
.v-navigation-drawer {
    background-color: #f5f5f5;
}
.v-btn__content {
    font-family: "'Roboto',sans-serif";
}
.v-btn {
    border-radius: 0px;
}
.v-btn--contained {
    box-shadow: 0 0px 0px 0px rgba(255, 255, 255, 0),
        0 0px 0px 0 rgba(255, 253, 253, 0.14),
        0 0px 0px 0 rgba(255, 255, 255, 0.12);
}
.v-application--is-ltr .v-list-item__icon:first-child {
    margin-right: 0;
}
.v-application a {
    text-decoration: none;
    color: darkorange;
}
.opencolor {
    color: white;
}
</style>
