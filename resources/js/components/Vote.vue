<template>

    <div class="col-md-1 icon">
        <div class="vote">
            <a :class="upVoteClass" @click.prevent="voteUp" :title="voteTitle('up')" href=""><i class="fas fa-angle-up fa-3x"></i></a>
            <div class="vote_counts "><b>{{count}}</b></div>
            <a :class="downVoteClass" @click.prevent="voteDown" :title="voteTitle('down')" href=""><i class="fas fa-angle-down fa-3x"></i></a>
        </div>

        <accept :model="model" v-if="name=='answer'"></accept>
        <favorite :model="model" v-if="name=='question'"></favorite>
    </div>

</template>

<script>
    import Favorite from "./Favorite";
    import Accept from "./Accept";
    export default {
        components: {Favorite,Accept},
        name: "Vote",
        props:['model','name'],

        data(){
            return{
               count: this.model.vote_counts,
               id: this.model.id,
               upVoted: this.model.is_up_vote,
               downVoted: this.model.is_down_vote,
            }
        },

        methods:{
              voteTitle($title){
                let titles = {
                  up : 'This question is useful for you',
                  down : 'This question is not useful for you',
                };
                return titles[$title]
              },

              voteUp(){
                  if(this.upVoted == true) return  false;
                  return this._vote(1);
              },
              voteDown(){
                  if(this.downVoted == true) return  false;
                  return this._vote(-1)
              },
              _vote(vote){
                  axios.post(this.endpoint,{
                      votes:vote
                  })
                      .then(response=>{
                          this.count = response.data.vote_counts;

                          if(vote == 1) {
                              this.upVoted = !this.upVoted;
                              this.downVoted = false;
                          }

                          else {
                              this.downVoted = !this.downVoted;
                              this.upVoted = false;
                          }

                      })
                      .catch(error=>{
                          console.log(error.response.data.message)
                      })
              }
        },

        computed:{
            endpoint(){
                return `/${this.name}s/${this.id}/vote`;
            },
            upVoteClass(){
                return [this.upVoted ? 'voted' : '']
            },
            downVoteClass(){
                return [this.downVoted ? 'voted' : '']
            }
        }
    }
</script>

<style scoped>

</style>
