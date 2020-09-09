/* Layouts */
import App from 'layouts/App';
import MainLayout from 'layouts/MainLayout';

export const mainLayout = (h, page) => h(App, [h(MainLayout, [page])]);

export default {
  mainLayout,
};
