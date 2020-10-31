<template>
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">MTA Transit Status</div>
                    <div class="card-body">
                        <form class="form-inline">
                            <div class="input-group mb-2 mr-sm-2">
                                <select
                                    placeholder="select one"
                                    v-model="selected"
                                    @change="onChange()"
                                    class="form-control"
                                >
                                    <option value="" disabled selected
                                        >Select Service Type</option
                                    >
                                    <option value="BT">BT</option>
                                    <option value="LIRR">LIRR</option>
                                    <option value="MetroNorth"
                                        >MetroNorth</option
                                    >
                                    <option value="bus">Bus</option>
                                    <option value="subway">Subway</option>
                                </select>
                            </div>

                            <button v-if="selectedObj" type="button" @click="storeFavorite()" class="btn btn-primary mb-2">
                                Add as favorite
                            </button>
                        </form>
                        <br /><br />
                        <div id="loader" v-if="isShow">
                            <h3>
                                {{ selected | properCase }} Status Updated:
                                {{ this.services.data.timestamp }}
                            </h3>

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
                                            <div
                                                v-if="
                                                    item.status ===
                                                        'SERVICE CHANGE'
                                                "
                                            >
                                                <small
                                                    v-html="item.text"
                                                    class="text-muted"
                                                ></small>
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
    props: ['currentUser'],
    data() {
        return {
            services: "",
            selected: "",
            selectedObj: null,
            isShow: false,
            loggedInUser:this.currentUser
        };
    },
    methods: {
        onChange() {
            console.log("The new value is: ", this.selected);
            this.selectedObj = this.services.data[this.selected];
            this.selectedObj ? (this.isShow = true) : (this.isShow = false);
            this.fetchData();
        },
        storeFavorite(){
            axios
                .post("api/favorites",{
                    name: this.selected,
                    data: this.selectedObj,
                    user_id: this.loggedInUser.id,
                    timestamp:this.services.data.timestamp

                })
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
