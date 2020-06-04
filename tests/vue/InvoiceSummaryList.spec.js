import {
   mount,
   shallowMount,
   createLocalVue
} from '@vue/test-utils';
import Vue from 'vue';
import Vuex from 'vuex';
import flushPromises from 'flush-promises';
import moxios from 'moxios';
import axios from 'axios';
import InvoiceSummaries from '@js/components/InvoiceSummaryListComponent.vue';
import ConfirmDelete from '@js/components/Utility/ConfirmDeleteComponent.vue';
import realStore from '@js/store';
import jquery from 'jquery';

const localVue = createLocalVue();
global.$ = jquery;

localVue.use(Vuex);

describe('invoice summary', () => {
   let store;

   let invoiceSummaryStore = {
      namespaced: true,
      state: {
         invoices: []
      },
      actions: {
         fetchInvoices: jest.fn(),
         deleteInvoiceSummary: () => { console.log('called fake'); }
      }
   }
   beforeEach(() => {
      store = new Vuex.Store({ 
         modules: { invoiceSummaryStore },
         state: {
            auth: {
               isLoggedIn: true
            }
         }
      });
      moxios.install();
   });

   afterEach(() => {
      moxios.uninstall();
   });

   it('does not render invoices if user is not logged in', (done) => {
      let store = realStore;

      // Here we are mimicing that the server will still respond with data even if user is not logged in.
      // this way we can be 100% sure that the test is actually passing correctly
      moxios.stubRequest('/invoices', {
         status: 200,
         response: {
            success: true,
            invoices:[
            {
               id: 1,
               invoice_no: '1234',
               store: { 
                  id: 3,
                  store_name: 'test store'
               },
               created_at: "2020-06-01 11:00:51",
               invoice_date: "2020-06-01 00:00:00",
               updated_at: "2020-06-01 11:00:51"
            }
         ]}
      });

      // given a user is not logged in
      const cmp = shallowMount(InvoiceSummaries, {
         sync: false,
         store,
         computed: {
            isAuthenticated: () => false
         },
         localVue
      });

      // he cannot see his invoices
      moxios.wait(() => {
         expect(cmp.html()).toContain('Please login to view your invoices');
         expect(cmp.html()).not.toContain('1234');
         done();
      });
   });

   it('renders invoices if user is logged in', (done) => {
      let store = realStore;
      moxios.stubRequest('/invoices', {
         status: 200,
         response: {
            success: true,
            invoices:[
            {
               id: 1,
               invoice_no: '1234',
               store_id: 3,
               created_at: "2020-06-01 11:00:51",
               invoice_date: "2020-06-01 00:00:00",
               updated_at: "2020-06-01 11:00:51"
            }
         ]}
      });

      // given a user is not logged in
      const cmp = shallowMount(InvoiceSummaries, {
         sync: false,
         store,
         computed: {
            isAuthenticated: () => true,
         },
         localVue
      });

      moxios.wait(() => {
         expect(cmp.html()).toContain('1234');
         done();
      });
   });

   it('makes an api call to fetch invoices when refresh button is clicked', () => {
      store.dispatch = jest.fn();
      const spy = jest.spyOn(store, 'dispatch');
      const wrapper = mount(InvoiceSummaries, {
         sync: false,
         store,
         computed: {
            isAuthenticated: () => { return true }
         },
         localVue
      });

      const refreshButton = wrapper.find('span.fa-sync');
      refreshButton.trigger('click');

      expect(spy.mock.calls[0][0]).toEqual(expect.stringContaining(spy.mock.calls[1][0]));
   });

   it('calls the appropriate dispatch action when delete button is clicked', async () => {
      const stubs = {
         ConfirmDelete
      };
      
      const dummyInvoice = {
         id: 999,
         invoice_no: '1234',
         store: { 
            id: 3,
            store_name: 'test store'
         },
         created_at: "2020-06-01 11:00:51",
         invoice_date: "2020-06-01 00:00:00",
         updated_at: "2020-06-01 11:00:51"
      };

      store.state.invoiceSummaryStore.invoices = [dummyInvoice];

      // returning promise as in vuex original dispatch returns a promise
      store.dispatch = jest.fn((method) => { return Promise.resolve() });

      // given a user is logged in
      const cmp = shallowMount(InvoiceSummaries, {
         sync: false,
         store,
         computed: {
            isAuthenticated: () => true               // Mimic user is loggedIn
         },
         scopedSlots: {                               // passing content for scoped slot
            'delete-btn': `<template slot-scope="{ invoice, confirmDelete }">
                  <button class="fas fa-trash-alt" @click="confirmDelete(invoice.id)"></button>
               </template>`
         },
         data() {
            return {
               showDeleteModal: true,
               invoiceSummaryIdToDelete: dummyInvoice.id
            }
         },
         stubs,
         methods: {
            confirmDelete: jest.fn(),
            afterDeleteInvoice: jest.fn()
         },
         localVue
      });

      const dltBtn = cmp.find('button.fa-trash-alt');
      dltBtn.trigger('click');                           // we can skip this. in reality this will show the confirm delete modal
      cmp.find('button.delete-entity').trigger('click');
      // await flushPromises();
      expect(store.dispatch).toBeCalledWith('invoiceSummaryStore/deleteInvoiceSummary', dummyInvoice.id);
   });
});
