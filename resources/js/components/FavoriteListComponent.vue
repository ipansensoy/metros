<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Your Favorite List</h3>
                <div v-for="(item, index) of favoriteList.data" class="card">
                    <div class="card-header">
                        {{ item.name }} | {{ item.status_timestamp }}
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Line Name</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="lineItem in item.data.line">
                                    <td>{{ lineItem.name }}</td>
                                    <td>
                                        {{ lineItem.status }}
                                        <div
                                            v-if="
                                                lineItem.status ===
                                                    'SERVICE CHANGE'
                                            "
                                        >
                                            <small
                                                v-html="lineItem.text"
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
</template>

<script>
export default {
    props: ["currentUser"],
    data() {
        return {
            loggedInUser: this.currentUser,
            favoriteList: []
        };
    },
    methods: {
        async fetchData() {
           await axios
                .get(`/api/favorites/${this.loggedInUser.id}`)
                .then(response => {
                    this.favoriteList = response;
                });
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
