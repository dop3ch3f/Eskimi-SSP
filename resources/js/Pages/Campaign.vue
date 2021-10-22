<template>
    <Head title="New Campaigns" ></Head>

    <BreezeAuthenticatedLayout>

      <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg -my-2">
                  <div class="md:grid md:grid-cols-3 md:gap-6 py-4 px-4">
                          <div class="md:col-span-1">
                              <div class="px-4 sm:px-0">
                                  <h3 class="text-lg font-medium leading-6 text-gray-900">Create Advertisement Campaign</h3>
                                  <p class="mt-1 text-sm text-gray-600">
                                      This information will be displayed publicly so be careful what you share.
                                  </p>
                              </div>
                          </div>
                          <div class="mt-5 md:mt-0 md:col-span-2">
                              <form @submit.prevent="submit">
                                  <div class="shadow sm:rounded-md sm:overflow-hidden">
                                      <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                          <template v-if="form.creative_uploads != null && form.creative_uploads[0] != null">
                                              <h1>Creative Uploads</h1>
                                              <img width="300" height="300" v-for="(i,index) in form.creative_uploads" :key="index" :src="i" alt="image" class="my-1">
                                          </template>
                                          <div class="grid grid-cols-3 gap-6">
                                              <div class="col-span-3 sm:col-span-2">
                                                  <label for="name" class="block text-sm font-medium text-gray-700">
                                                      Name
                                                  </label>
                                                  <div class="mt-1 flex rounded-md shadow-sm">
                                                      <input type="text" name="name" id="name" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="Input a name for this campaign" v-model="form.name">
                                                  </div>
                                              </div>
                                          </div>

                                          <div>
                                              <label for="total_budget" class="block text-sm font-medium text-gray-700">
                                                  Total Budget
                                              </label>
                                              <div class="mt-1">
                                                  <input id="total_budget" name="total_budget" type="number" min="0" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="input your total budget" v-model="form.total_budget">
                                              </div>
                                          </div>

                                          <div>
                                              <label for="daily_budget" class="block text-sm font-medium text-gray-700">
                                                  Daily Budget
                                              </label>
                                              <div class="mt-1">
                                                  <input id="daily_budget" name="total_budget" type="number" min="0" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="input your total budget" v-model="form.daily_budget">
                                              </div>
                                          </div>

                                          <div>
                                              <label for="from" class="block text-sm font-medium text-gray-700">
                                                  Start (From)
                                              </label>
                                              <div class="mt-1">
                                                  <input id="from" name="from" type="date" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="input your total budget" v-model="form.from">
                                              </div>
                                          </div>

                                          <div>
                                              <label for="to" class="block text-sm font-medium text-gray-700">
                                                  Stop (To)
                                              </label>
                                              <div class="mt-1">
                                                  <input id="to" name="from" type="date" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="input your total budget" v-model="form.to">
                                              </div>
                                          </div>

                                          <div>
                                              <label class="block text-sm font-medium text-gray-700">
                                                  Creative Upload
                                              </label>
                                              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                                  <div class="space-y-1 text-center">
                                                      <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                          <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                      </svg>
                                                      <div class="flex text-sm text-gray-600">
                                                          <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                              <span>Upload a file</span>
                                                              <input id="file-upload" name="file-upload" type="file" @input="onFileInput($event)" class="sr-only" multiple>
                                                          </label>
                                                          <p class="pl-1">or drag and drop</p>
                                                      </div>
                                                      <p class="text-xs text-gray-500">
                                                          PNG, JPG, GIF, Video up to 10MB
                                                      </p>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                          <button v-if="form.id == null" type="submit" :disabled="loading" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                              {{ loading ? 'Submitting..' : 'Submit' }}
                                          </button>
                                          <button v-else type="submit" :disabled="loading" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                              {{ loading ? 'Saving Changes..' : 'Save' }}
                                          </button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </div>
              </div>
          </div>
      </div>

    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
export default {
    name: "New",
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    data() {
        return {
            form: {
                name: null,
                total_budget: null,
                daily_budget: null,
                from:null,
                to: null,
                creative_upload: null
            },
            loading: false,
        };
    },
    computed: {
        user() {
            return this.$page.props.auth.user
        },
        campaign() {
            return this.$page.props.campaign
        }
    },
    mounted() {
        if(this.campaign != null && this.campaign.data != null) {
            Object.assign(this.form,this.campaign.data);
        }
    },
    methods: {
        onFileInput(event) {
            this.form.creative_upload = event.target.files
            this.form.creative_uploads =null;
            alert("files added successfully");
        },
        async submit() {
           try{
               this.loading = true;
               const formData = new FormData();

               Object.entries(this.form).forEach(([key, value]) => {
                   if(key === 'creative_upload' && value != null) {
                       Object.entries(value).forEach((val,i) => {
                           formData.append(`creative_upload[${i}]`, value.item(i));
                       })
                   } else {
                       formData.append(key, value);
                   }
               });

               if(this.form.id != null) {
                   formData.append("_method", "PUT")
                   await axios.post(`/api/advertisement-campaign/${this.form.id}`, formData);
                   alert("campaign updated");
                   window.location.reload();
               } else{
                   await axios.post('/api/advertisement-campaign', formData);
                   alert("campaign created");
                   window.location.reload();
               }
           } catch(e) {
               alert("An error occurred: " + e.message);
               console.log(e);
           } finally {
               this.loading = false;
           }

       }
    },
}
</script>

<style scoped>

</style>
