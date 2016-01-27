import SettingsModal from 'flarum/components/SettingsModal';

export default class AzonwanSettingsModal extends SettingsModal {
  className() {
    return 'AzonwanSettingsModal Modal--small';
  }

  title() {
    return 'QQ Settings';
  }

  form() {
    return [
      <div className="Form-group">
        <label>Client ID</label>
        <input className="FormControl" bidi={this.setting('azonwan-auth-qq.client_id')}/>
      </div>,

      <div className="Form-group">
        <label>Client Secret</label>
        <input className="FormControl" bidi={this.setting('azonwan-auth-qq.client_secret')}/>
      </div>
    ];
  }
}
