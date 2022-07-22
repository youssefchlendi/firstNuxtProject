<template>
  <v-container>
    <v-row justify="center">
      <v-col cols="12" md="8">
        <v-card>
          <h1 v-if="post">{{ post.title }}</h1>
          <p v-if="post">
            {{ post.body }}
          </p>
          <h1 v-else>not fount</h1>
        </v-card>
      </v-col>
      <v-col>
        <v-card>
          <v-card-title>
            <h3>Related Posts</h3>
          </v-card-title>
          <v-card-text>
            <v-list>
              <v-list-item v-for="p in relatedPosts" :key="p.id">
                <v-list-item-content>
                  <v-list-item-title>
                    <router-link :to="{ name: 'posts-id', params: { id: p.id } }">
                      {{ p.title }}
                    </router-link>
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data () {
    return {
      id: this.$route.params.id ?? 1
    }
  },
  computed: {
    post () {
      return this.$store.state.posts.posts.find(post => post.id === this.id)
    },
    relatedPosts () {
      return this.$store.state.posts.posts.filter(post => post.id !== this.id)
    }
  }
}
</script>
