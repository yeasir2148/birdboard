import {
   shallow,
   mount,
   shallowMount
} from '@vue/test-utils';
import moxios from 'moxios';
import expect from 'expect';
import Categories from '../../resources/js/components/CategoriesComponent.vue';
import VeeValidate from 'vee-validate';

describe('Categories', () => {

   let wrapper;
   beforeEach(() => {
      // console.log('callling before each');
      moxios.install(axios);
      // wrapper = shallowMount(Categories);
   });

   afterEach(() => {
      moxios.uninstall(axios);
   });

   it('renders All Categories', () => {
      wrapper = shallowMount(Categories, { sync: false });
      const vm = wrapper.vm
      expect(wrapper.html()).toContain('Category');
      wrapper.destroy();
   });

   it('has a name data property that defaults to null', () => {
      wrapper = shallowMount(Categories, { sync: false });
      expect(wrapper.vm.form.name).toBe(null);
      wrapper.destroy();
   });

   it('has a categoryCode data property that defaults to null', () => {
      wrapper = shallowMount(Categories, { sync: false });
      expect(wrapper.vm.form.categoryCode).toBe(null);
      wrapper.destroy();
   });

   it('it fetches categogies upon being mounted', function (done) {

      moxios.stubRequest('/categories', {
         status: 200,
         response: [
            {
               name: 'Fish',
               category_code: 1,
               id: 5
            }
         ],
      }, 2000);

      wrapper = shallowMount(Categories, { sync: false });



      moxios.wait(() => {
         expect(wrapper.vm.categories.length).toBe(1);
         expect(wrapper.html()).toContain('Fish');
         done();
      });
   });

   it.only('calls a post api on create button click', function (done) {
      const wrapper1 = mount(Categories);

      // moxios.stubRequest('/categories', {
      //    status: 200,
      //    response: {
      //       success: true,
      //       data: {
      //          name: 'Meat',
      //          category_code: 'meat',
      //          id: 5
      //       }
      //    }
      // });

      wrapper1.find('input[name="name"]').setValue('Meat');
      wrapper1.find('input[name="category_code"]').setValue('meat');
      wrapper1.find('#createCategoryForm').trigger('submit.prevent');

      expect(wrapper1.vm.form.name).toBe('Meat');
      expect(wrapper1.vm.form.categoryCode).toBe('meat');

      moxios.wait(() => {
         // console.log((moxios.requests.mostRecent().config));
         const request = moxios.requests.mostRecent();
         if (request.config.method === 'post') {
            console.log('here');
            request.respondWith({
               status: 200,
               response: {
                  success: true,
                  data: {
                     name: 'Meat',
                     category_code: 'meat',
                     id: 5
                  }
               }
            });
         }

         expect(moxios.requests.mostRecent().config.method).toEqual('post');

         done();
      });
   });
});
