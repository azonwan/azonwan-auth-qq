import app from 'flarum/app';

import AzonwanSettingsModal from 'azonwan/auth/qq/components/QQSettingsModal';

app.initializers.add('azonwan-auth-qq', () => {
  app.extensionSettings['azonwan-auth-qq'] = () => app.modal.show(new QQSettingsModal());
});
