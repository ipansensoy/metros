<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">MTA Transmit Status</div>
                    <div class="card-body">
                        <select
                            placeholder="select one"
                            v-model="selected"
                            @change="onChange()"
                            class="form-control"
                        >
                            <option value="" disabled selected
                                >Select one</option
                            >
                            <option value="BT">BT</option>
                            <option value="LIRR">LIRR</option>
                            <option value="MetroNorth">MetroNorth</option>
                            <option value="bus">Bus</option>
                            <option value="subway">Subway</option> </select
                        ><br /><br />
                        <div id="loader" v-if="isShow">
                            <h3>
                                {{ selected | properCase }} Status Updated:
                                {{ this.services.data.timestamp }}
                            </h3>

                            <!-- <ul>
                                <li v-for ="item in selectedObj.line">
                                    <h3>{{item.name}}</h3>
                                </li>
                            </ul> -->
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Line Name</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in selectedObj.line">
                                        <td>{{ item.name }}</td>
                                        <td>
                                            {{ item.status }}
                                            <div v-if="item.status ==='SERVICE CHANGE'">
                                                <small v-html="item.text" class="text-muted"
                                                    ></small
                                                >
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            services: "",
            selected: "",
            selectedObj: null,
            isShow: false
        };
    },
    methods: {
        onChange() {
            console.log("The new value is: ", this.selected);
            this.selectedObj = this.services.data[this.selected];
            this.selectedObj ? (this.isShow = true) : (this.isShow = false);
            this.fetchData();
        },
        fetchData() {
            axios
                .get("api/metro-list")
                .then(response => (this.services = response));
        }
    },
    filters: {
        properCase(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    },
    mounted() {
        this.fetchData();
    }
};
</script>
