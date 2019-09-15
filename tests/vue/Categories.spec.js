import {
   shallow,
   mount,
   shallowMount
} from '@vue/test-utils';
import moxios from 'moxios';
import expect from 'expect';
import Categories from '../../resources/js/components/CategoriesComponent.vue';
import VeeValidate from 'vee-validate';
import flushPromises from "flush-promises";

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
      wrapper = shallowMount(Categories, { sync: false });
      // console.log(22222222);

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
      // let wrapper1 = shallowMount(Categories);
      moxios.wait(() => {
         // console.log(33333);
         expect(wrapper.vm.categories.length).toBe(1);
         expect(wrapper.html()).toContain('Fish');
         // console.log(wrapper.text());
         done();
      });
      // wrapper.destroy();
   });

   it('calls an api on create button click', function (done) {
      let wrapper1 = mount(Categories, { sync: true });

      moxios.stubRequest('/categories', {
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

      wrapper1.find('input[name="name"]').setValue('Meat');
      wrapper1.find('input[name="category_code"]').setValue('Meat');
      wrapper1.find('#createCategoryForm').trigger('submit.prevent');

      // await flushPromises();
      // expect(wrapper1.text()).toContain('New Category');
      moxios.wait(() => {
         expect(wrapper1.text()).toContain('Meat');
         // expect(wrapper1.vm.form.name).toBe('Meat');
         wrapper1.destroy();
         done();
      });
      // wrapper1.destroy();
   });
});
