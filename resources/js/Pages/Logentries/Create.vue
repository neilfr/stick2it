<template>
    <app-layout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Add Log Entry
                </h2>
                <button @click="cancel">
                    <img class="w-6" src="/images/close.svg">
                </button>
            </div>
        </template>
        <div>
                <div class="grid grid-cols-12 gap-2">
                    <button class="border rounded col-span-2" @click="handlePickFood">Pick Food</button>
                    <button class="border rounded col-span-2" :disabled="!readyToSave" @click="store">Save</button>
                    <div class="col-span-8"></div>

                    <p class="col-span-12" v-if="errors.consumed_at">{{errors.consumed_at}}</p>
                    <label class="py-2 col-span-2" for="consumed_at">Consumed at:</label>
                    <input class="border rounded col-span-2" id="consumed_at_date" type="date" v-model="logentry.consumed_at">
                    <p class="col-span-8"></p>

                    <p class="col-span-12" v-if="errors.quantity">{{errors.quantity}}</p>
                    <label class="py-2 col-span-2" for="quantity">Quantity:</label>
                    <input class="border rounded col-span-2" id="quantity" type="number" min="0" v-model="logentry.quantity">
                    <p class="col-span-8"></p>

                    <p class="col-span-12" v-if="errors.description">{{errors.consumed_at}}</p>
                    <label class="py-2 col-span-2" for="description">Description:</label>
                    <input disabled class="border rounded col-span-10" id="description" type="text" :value="this.description">

                    <p class="col-span-12" v-if="errors.kcal">{{errors.kcal}}</p>
                    <label class="py-2 col-span-2" for="kcal">KCal:</label>
                    <input disabled class="border rounded col-span-2" id="kcal" type="number" min="0" :value="this.kcal">
                    <p class="col-span-8"></p>

                    <p class="col-span-12" v-if="errors.fat">{{errors.fat}}</p>
                    <label class="py-2 col-span-2" for="fat">Fat:</label>
                    <input disabled class="border rounded col-span-2" id="fat" type="number" min="0" :value="this.fat">
                    <p class="col-span-8"></p>

                    <p class="col-span-12" v-if="errors.protein">{{errors.protein}}</p>
                    <label class="py-2 col-span-2" for="protein">Protein:</label>
                    <input disabled class="border rounded col-span-2" id="protein" type="number" min="0" :value="this.protein">
                    <p class="col-span-8"></p>

                    <p class="col-span-12" v-if="errors.carbohydrate">{{errors.carbohydrate}}</p>
                    <label class="py-2 col-span-2" for="carbohydrate">Carbohydrate:</label>
                    <input disabled class="border rounded col-span-2" id="carbohydrate" type="number" min="0" :value="this.carbohydrate">
                    <p class="col-span-8"></p>

                    <p class="col-span-12" v-if="errors.potassium">{{errors.potassium}}</p>
                    <label class="py-2 col-span-2" for="potassium">Potassium:</label>
                    <input disabled class="border rounded col-span-2" id="potassium" type="number" min="0" :value="this.potassium">
                    <p class="col-span-8"></p>
                </div>

            <div v-if="showSelectFoodModal" class="fixed inset-0 w-full h-screen flex items-center justify-center overflow-auto">
                <div class="w-full max-w-6xl bg-white shadow-lg rounded-lg p-8">
                    <div class="flex justify-between">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            Pick Food
                        </h2>
                        <button @click="closePickFoodModal">
                            <img class="w-6" src="/images/close.svg">
                        </button>
                    </div>
                    <section class="py-2 grid grid-cols-12 gap-2">
                        <label class="col-span-2" for="aliasSearch">Alias:</label>
                        <input class="border col-span-4" type="text" name="aliasSearch" id="aliasSearch" @input="goToPageOne" v-model="aliasSearchText" placeholder="Alias Search"/>
                        <div class="col-span-6"></div>

                        <label class="col-span-2" for="descriptionSearch">Description:</label>
                        <input class="border col-span-4" type="text" name="descriptionSearch" id="descriptionSearch" @input="goToPageOne" v-model="descriptionSearchText" placeholder="Description Search"/>
                        <div class="col-span-6"></div>

                        <label class="col-span-2" for="foodgroups">Food Group:</label>
                        <select class="border col-span-4" name="foodgroups" id="foodgroups" v-model="foodgroupFilter" @change="goToPageOne">
                            <option value="">All</option>
                            <option v-for="foodgroup in foodgroups.data" :key="foodgroup.id" :value="foodgroup.id">
                                {{ foodgroup.description }}
                            </option>
                        </select>
                        <div class="col-span-6"></div>

                        <div class="flex col-span-2">
                            <p>Favourites:</p>
                        </div>
                        <div>
                            <label for="favouriteYes">Yes</label>
                            <input type="radio" name="favourites" id="favouriteYes" value="yes" v-model="favouritesFilter" @change="goToPageOne">
                        </div>
                        <div>
                            <label for="favouriteNo">No</label>
                            <input type="radio" name="favourites" id="favouriteNo" value="no" v-model="favouritesFilter" @change="goToPageOne">
                            </div>
                        <div class="col-span-6"></div>
                    </section>
                    <table class="table-fixed w-full mt-2">
                        <tr>
                            <th>Favourite</th>
                            <th>Alias</th>
                            <th class="w-1/3">Description</th>
                            <th class="text-left translate-x-4 transform -rotate-45 origin-bottom-left">Base Quantity</th>
                            <th class="text-left translate-x-4 transform -rotate-45 origin-bottom-left">KCal</th>
                            <th class="text-left translate-x-4 transform -rotate-45 origin-bottom-left">Protein</th>
                            <th class="text-left translate-x-4 transform -rotate-45 origin-bottom-left">Fat</th>
                            <th class="text-left translate-x-4 transform -rotate-45 origin-bottom-left">Carbohydrate</th>
                            <th class="text-left translate-x-4 transform -rotate-45 origin-bottom-left">Potassium</th>
                            <th class="text-left translate-x-4 transform -rotate-45 origin-bottom-left">Actions</th>
                        </tr>
                        <tr v-for="food in foods.data" :key="food.id" class="odd:bg-gray-100 leading-9">
                            <td>
                                <div class="ml-2">
                                    <input type="checkbox" name="favourites" id="favourite" disabled :checked="food.favourite">
                                </div>
                            </td>
                            <td class="w-5 text-center">{{food.alias}}</td>
                            <td class="truncate">{{food.description}}</td>
                            <td>{{food.base_quantity}}</td>
                            <td>{{Math.round(food.kcal)}}</td>
                            <td>{{Math.round(food.protein)}}</td>
                            <td>{{Math.round(food.fat)}}</td>
                            <td>{{Math.round(food.carbohydrate)}}</td>
                            <td>{{Math.round(food.potassium)}}</td>
                            <td>
                                <button @click="selectFood(food)">
                                    <img class="w-6" src="/images/add-outline.svg">
                                </button>
                            </td>
                        </tr>
                    </table>
                    <div class="grid grid-cols-12 gap-2 mt-2">
                        <button class="col-span-1 border rounded" @click="goToPageOne">First</button>
                        <button class="col-span-1 border rounded" @click="previousPage">Previous</button>
                        <button class="col-span-1 border rounded" @click="nextPage">Next</button>
                        <button class="col-span-1 border rounded" @click="lastPage">Last</button>
                        <p class="col-span-2">Page: {{foods.meta.current_page}} of {{foods.meta.last_page}}</p>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout';

export default {
    components: {
        AppLayout,
    },
    props: {
        errors: Object,
        user: Object,
        foods: Object,
        foodgroups: Object
    },
    computed: {
        readyToSave () {
            return this.logentry.quantity>0 && !isNaN(new Date(this.logentry.consumed_at).getDate()) && this.selectedFood!=null;
        },
        description () {
            return this.selectedFood ? this.selectedFood.description : '';
        },
        kcal () {
            return this.selectedFood ? Math.round(this.selectedFood.kcal * this.logentry.quantity / this.selectedFood.base_quantity) : 0;
        },
        fat () {
            return this.selectedFood ? Math.round(this.selectedFood.fat * this.logentry.quantity / this.selectedFood.base_quantity) : 0;
        },
        protein () {
            return this.selectedFood ? Math.round(this.selectedFood.protein * this.logentry.quantity / this.selectedFood.base_quantity) : 0;
        },
        carbohydrate () {
            return this.selectedFood ? Math.round(this.selectedFood.carbohydrate * this.logentry.quantity / this.selectedFood.base_quantity) : 0;
        },
        potassium () {
            return this.selectedFood ? Math.round(this.selectedFood.potassium * this.logentry.quantity / this.selectedFood.base_quantity) : 0;
        }
    },
    data() {
        return {
            showSelectFoodModal: false,
            descriptionSearchText: '',
            aliasSearchText: '',
            foodgroupFilter: '',
            favouritesFilter: 'yes',
            page: 1,
            logentry: {
                user_id: this.user.id,
                quantity: 0,
                consumed_at: (new Date()).toISOString().substr(0,10),
            },
            selectedFood: null
        }
    },
    methods: {
        store(){
            this.$inertia.post(
                this.$route("logentries.store"),
                {
                    'user_id': this.user.id,
                    'quantity': this.logentry.quantity,
                    'food_id': this.selectedFood.id,
                    'consumed_at': this.logentry.consumed_at
                }
            )
        },
        handlePickFood(){
            this.showSelectFoodModal = true;
        },
        closePickFoodModal(){
            this.showSelectFoodModal = false;
        },
        selectFood(food){
            this.selectedFood=food;
            if(this.logentry.quantity===0){
                this.logentry.quantity = food.base_quantity
            }
            this.showSelectFoodModal = false;
        },
        goToPageOne(){
            this.page=1;
            this.goToPage(1);
        },
        previousPage(){
            if(this.page>1){
                this.page--;
                this.goToPage();
            }
        },
        nextPage(){
            if(this.page<this.foods.meta.last_page){
                this.page++;
                this.goToPage();
            }
        },
        lastPage(){
            this.page = this.foods.meta.last_page;
            this.goToPage();
        },
        goToPage(){
            let url = `${this.$route("logentries.create")}`;
            url += `?descriptionSearch=${this.descriptionSearchText}`;
            url += `&aliasSearch=${this.aliasSearchText}`;
            url += `&foodgroupSearch=${this.foodgroupFilter}`;
            url += `&favouritesFilter=${this.favouritesFilter}`;
            this.$inertia.visit(url, {
                data:{
                    'page':this.page
                },
                preserveState: true,
                preserveScroll: true,
            });
        },
        cancel(){
            let url = `${this.$route("logentries.index")}`;
            this.$inertia.visit(url);
        }
    }
}
</script>
