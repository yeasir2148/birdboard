import {
   mount,
   shallowMount,
   createLocalVue
} from '@vue/test-utils';
import Vue from 'vue';
import Vuex from 'vuex';
import flushPromises from 'flush-promises';
import moxios from 'moxios';
import Categories from '@js/components/CategoriesComponent.vue';
import axios from 'axios';
import realStore from '@js/store';

const localVue = createLocalVue();
localVue.use(Vuex);

describe('Categories', () => {
   let store;

   let categoryStore = {
      namespaced: true,
      state: {
         categories: []
      },
      actions: {
         fetchCategories: () => {
            axios.get('/categories');
         }
      },
   };

   beforeEach(() => {
      store = new Vuex.Store({
         modules: { categoryStore },
      });
      moxios.install();
   })

   afterEach(function () {
      // import and pass your custom axios instance to this method
      moxios.uninstall()
   });
    
   it('does not show create button if user is not logged in', () => {
      const wrapper = mount(Categories, {
         sync: false,
         store,
         computed: {
            isAuthenticated: () => { return false }
         },
         localVue
      });
      expect(wrapper.find('button.create-category').exists()).toBe(false);
      wrapper.destroy();
   });

   it('shows create button if user is logged in', () => {
      const wrapper = mount(Categories, {
         sync: false,
         store,
         computed: {
            isAuthenticated: () => { return true }
         },
         localVue
      });
      // console.log(wrapper);
      expect(wrapper.find('button.create-category').exists()).toBe(true);
      wrapper.destroy();
   });

   it('has the create button disabled if form is invalid', () => {
      const wrapper = mount(Categories, {
         sync: false,
         store,
         computed: {
            isAuthenticated: () => { return true }
         },
         localVue
      });

      expect(wrapper.find('button.create-category').attributes().disabled).toBe('disabled');
      wrapper.destroy();
   });

   it('has the create button enabled if form is valid', async () => {
      const wrapper = mount(Categories, {
         sync: false,
         store,
         computed: {
            isAuthenticated: () => { return true }
         },
         localVue
      });

      const elem = wrapper.find('input[name="name"]');
      elem.setValue('some category');
      await flushPromises();

      expect(wrapper.find('button.create-category').attributes().disabled).toBe(undefined);
      wrapper.destroy();
   });

   
   it('it dispatches an action to fetch categories', async function () {
      store.dispatch = jest.fn();
      const wrapper = shallowMount(Categories, {
         sync: false,
         store,
         computed: {
            isAuthenticated: () => { return true }
         },
         localVue
      });

      await wrapper.vm.$nextTick();
      expect(store.dispatch).toHaveBeenCalledWith(
         'categoryStore/fetchCategories', undefined);
   });

   it('it renders categories after mount by fetching categories', async function (done) {
      const store = realStore;
      moxios.stubRequest('/categories', {
         status: 200,
         response: [
            {
               id: 1,
               name: 'Fish',               
            },
            {
               id: 2,
               name: 'Cow',               
            }
         ]
      })
      const wrapper = shallowMount(Categories, {
         sync: false,
         store,
      });

      moxios.wait(() => {
         expect(wrapper.html()).toContain('Fish');
         expect(wrapper.html()).toContain('Cow');
         expect(wrapper.vm.$data.filteredCategories.length).toBe(2);
         done();
      });
   });

   it('makes an api call to server when refresh button is clicked', () => {
      store.dispatch = jest.fn();

      const wrapper = mount(Categories, {
         sync: false,
         store,
         computed: {
            isAuthenticated: () => { return true }
         },
         localVue
      });

      const refreshButton = wrapper.find('span.fa-sync');
      refreshButton.trigger('click');
      expect(store.dispatch).toHaveBeenNthCalledWith(1, 'categoryStore/fetchCategories', undefined);
      expect(store.dispatch).toHaveBeenNthCalledWith(2, 'categoryStore/fetchCategories', undefined);
   });

   // The below test can be writeen as below
   it('makes an api call when refresh button is clicked', () => {
      store.dispatch = jest.fn();
      const spy = jest.spyOn(store, 'dispatch');
      const wrapper = mount(Categories, {
         sync: false,
         store,
         computed: {
            isAuthenticated: () => { return true }
         },
         localVue
      });

      const refreshButton = wrapper.find('span.fa-sync');
      refreshButton.trigger('click');

      // console.log(expect(spy.mock.calls[0][0]));
      // console.log(expect(['Alice', 'Bob', 'Eve']));
      // console.log(expect.not.arrayContaining(['shamanta']));
      expect(spy.mock.calls[0][0]).toEqual(expect.stringContaining(spy.mock.calls[1][0]));
   })
});

// import moxios from 'moxios';
// import expect from 'expect';
// import Categories from '../../resources/js/components/CategoriesComponent.vue';
// import VeeValidate from 'vee-validate';

// describe('Categories', () => {

//    let wrapper;
//    beforeEach(() => {
//       // console.log('callling before each');
//       moxios.install(axios);
//       // wrapper = shallowMount(Categories);
//    });

//    afterEach(() => {
//       moxios.uninstall(axios);
//    });

//    it('renders All Categories', () => {
//       wrapper = shallowMount(Categories, { sync: false });
//       const vm = wrapper.vm
//       expect(wrapper.html()).toContain('Category');
//       wrapper.destroy();
//    });

//    it('has a name data property that defaults to null', () => {
//       wrapper = shallowMount(Categories, { sync: false });
//       expect(wrapper.vm.form.name).toBe(null);
//       wrapper.destroy();
//    });

//    it('has a categoryCode data property that defaults to null', () => {
//       wrapper = shallowMount(Categories, { sync: false });
//       expect(wrapper.vm.form.categoryCode).toBe(null);
//       wrapper.destroy();
//    });

//    it('it fetches categogies upon being mounted', function (done) {

//       moxios.stubRequest('/categories', {
//          status: 200,
//          response: [
//             {
//                name: 'Fish',
//                category_code: 1,
//                id: 5
//             }
//          ],
//       }, 2000);

//       wrapper = shallowMount(Categories, { sync: false });



//       moxios.wait(() => {
//          expect(wrapper.vm.categories.length).toBe(1);
//          expect(wrapper.html()).toContain('Fish');
//          done();
//       });
//    });

//    it.only('calls a post api on create button click', function (done) {
//       const wrapper1 = mount(Categories);

//       // moxios.stubRequest('/categories', {
//       //    status: 200,
//       //    response: {
//       //       success: true,
//       //       data: {
//       //          name: 'Meat',
//       //          category_code: 'meat',
//       //          id: 5
//       //       }
//       //    }
//       // });

//       wrapper1.find('input[name="name"]').setValue('Meat');
//       wrapper1.find('input[name="category_code"]').setValue('meat');
//       wrapper1.find('#createCategoryForm').trigger('submit.prevent');

//       expect(wrapper1.vm.form.name).toBe('Meat');
//       expect(wrapper1.vm.form.categoryCode).toBe('meat');

//       moxios.wait(() => {
//          // console.log((moxios.requests.mostRecent().config));
//          const request = moxios.requests.mostRecent();
//          if (request.config.method === 'post') {
//             console.log('here');
//             request.respondWith({
//                status: 200,
//                response: {
//                   success: true,
//                   data: {
//                      name: 'Meat',
//                      category_code: 'meat',
//                      id: 5
//                   }
//                }
//             });
//          }

//          expect(moxios.requests.mostRecent().config.method).toEqual('post');

//          done();
//       });
//    });
// });
