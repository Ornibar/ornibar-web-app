<template>
  <div id="main-content">
    <!-- AppComponent -->
    <div class="grid gap-4 grid-cols-2 md:grid-cols-3">
      <div class="card-route flex justify-center items-center rounded-lg" v-for="route in routes" :key="route">
        <router-link to="user">
            <h1 class="text-3xl">{{ route.name }}</h1>
        </router-link>
      </div>
    </div>
    
  </div>
</template>

<script>
export default {
    created() {
        this.$router.options.routes.forEach(route => {
          if(route.name != "app") {
              this.routes.push({
                  name: route.name
                  ,path: route.path
              })
          }
        })
    }
    ,data() {
        return {
            routes: [],
        }
    }
}
</script>

<style>
.card-route {
  background: lightblue;
  height: 130px;
  max-width: 300px;
}
</style>