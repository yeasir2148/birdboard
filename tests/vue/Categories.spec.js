import {
   shallow,
   mount
} from '@vue/test-utils';
import moxios from 'moxios';
import expect from 'expect';
import Categories from '../../resources/js/components/CategoriesComponent.vue';

describe('Categories', () => {
   let wrapper = mount(Categories);
   beforeEach(() => {
      moxios.install(axios);
   });

   afterEach(() => {
      moxios.uninstall(axios);
   });

   it('renders All Categories', () => {
      expect(wrapper.html()).toContain('Category');
   });

   it('has a name that defaults to null', () => {
      expect(wrapper.vm.name).toBe(null);
   });
});
