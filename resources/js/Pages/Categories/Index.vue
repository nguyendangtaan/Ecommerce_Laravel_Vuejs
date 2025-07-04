<template lang="">
    <div>
        <Dashboard></Dashboard>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Categories</div>

                        <div class="card-body">
                            I'm a categories component.
                            <Categories />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Dashboard from "../Dashboard.vue"
export default {
    components: {
        Dashboard,
    },

}
</script>
<style lang="">
    
</style>