System.register('azonwan/auth/qq/main', ['flarum/extend', 'flarum/app', 'flarum/components/LogInButtons', 'flarum/components/LogInButton'], function (_export) {
  'use strict';

  var extend, app, LogInButtons, LogInButton;
  return {
    setters: [function (_flarumExtend) {
      extend = _flarumExtend.extend;
    }, function (_flarumApp) {
      app = _flarumApp['default'];
    }, function (_flarumComponentsLogInButtons) {
      LogInButtons = _flarumComponentsLogInButtons['default'];
    }, function (_flarumComponentsLogInButton) {
      LogInButton = _flarumComponentsLogInButton['default'];
    }],
    execute: function () {

      app.initializers.add('azonwan-auth-qq', function () {
        extend(LogInButtons.prototype, 'items', function (items) {
          items.add('qq', m(
            LogInButton,
            {
              className: 'Button LogInButton--qq',
              icon: 'qq',
              path: '/auth/qq' },
            'Log in with QQ'
          ));
        });
      });
    }
  };
});