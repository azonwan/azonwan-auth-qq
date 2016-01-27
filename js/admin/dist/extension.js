System.register('azonwan/auth/qq/components/QQSettingsModal', ['flarum/components/SettingsModal'], function (_export) {
  'use strict';

  var SettingsModal, QQSettingsModal;
  return {
    setters: [function (_flarumComponentsSettingsModal) {
      SettingsModal = _flarumComponentsSettingsModal['default'];
    }],
    execute: function () {
      QQSettingsModal = (function (_SettingsModal) {
        babelHelpers.inherits(QQSettingsModal, _SettingsModal);

        function QQSettingsModal() {
          babelHelpers.classCallCheck(this, QQSettingsModal);
          babelHelpers.get(Object.getPrototypeOf(QQSettingsModal.prototype), 'constructor', this).apply(this, arguments);
        }

        babelHelpers.createClass(QQSettingsModal, [{
          key: 'className',
          value: function className() {
            return 'QQSettingsModal Modal--small';
          }
        }, {
          key: 'title',
          value: function title() {
            return 'QQ Settings';
          }
        }, {
          key: 'form',
          value: function form() {
            return [m(
              'div',
              { className: 'Form-group' },
              m(
                'label',
                null,
                'Client ID'
              ),
              m('input', { className: 'FormControl', bidi: this.setting('azonwan-auth-qq.client_id') })
            ), m(
              'div',
              { className: 'Form-group' },
              m(
                'label',
                null,
                'Client Secret'
              ),
              m('input', { className: 'FormControl', bidi: this.setting('azonwan-auth-qq.client_secret') })
            )];
          }
        }]);
        return QQSettingsModal;
      })(SettingsModal);

      _export('default', QQSettingsModal);
    }
  };
});;
System.register('azonwan/auth/qq/main', ['flarum/app', 'azonwan/auth/qq/components/QQSettingsModal'], function (_export) {
  'use strict';

  var app, QQSettingsModal;
  return {
    setters: [function (_flarumApp) {
      app = _flarumApp['default'];
    }, function (_azonwanAuthQQComponentsQQSettingsModal) {
      QQSettingsModal = _azonwanAuthQQComponentsQQSettingsModal['default'];
    }],
    execute: function () {

      app.initializers.add('azonwan-auth-qq', function () {
        app.extensionSettings['azonwan-auth-qq'] = function () {
          return app.modal.show(new QQSettingsModal());
        };
      });
    }
  };
});