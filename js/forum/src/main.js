import { extend } from 'flarum/extend';
import app from 'flarum/app';
import LogInButtons from 'flarum/components/LogInButtons';
import LogInButton from 'flarum/components/LogInButton';

app.initializers.add('azonwan-auth-qq', () => {
  extend(LogInButtons.prototype, 'items', function(items) {
    items.add('qq',
      <LogInButton
        className="Button LogInButton--qq"
        icon="qq"
        path="/auth/qq">
        Log in with QQ
      </LogInButton>
    );
  });
});
