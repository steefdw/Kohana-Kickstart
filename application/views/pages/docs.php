<h2><?php echo __('Documentation'); ?></h2>
Nowhere near finished, but let me tell you a few things about these topics:<br><br>

<div class="subnav">
  <ul class="nav nav-pills">
    <li class="active"><a href="#orm">ORM</a></li>
    <li class=""><a href="#forms">Forms</a></li>
    <li class=""><a href="#messages">Messages</a></li>
    <li class=""><a href="#pagination">Pagination</a></li>
    <li class=""><a href="#email">Email</a></li>
  </ul>
</div>

<div class="section" id="orm">
  <div class="section-header">
      <h3>Extended Kohana ORM class</h3>
  </div>

<h4>$object->is_changed()</h4>
<div class="row">
  <div class="span6">
    Check if updated values made some changes to the object.
  </div>
  <div class="span6">
    <strong>example usage:</strong>
    <pre class="prettyprint linenums">if ($user->is_changed())
    echo 'succesfully updated your account';
// else: user clicked on update,
// but didn't make any changes in the form</pre>
  </div>
</div>
<br>

<h4>$object->generate_hash()</h4>
<div class="row">
  <div class="span6">
    Can be used for passwords, tokens or other random strings
  </div>
  <div class="span6">
    <strong>example usage:</strong>
    <pre class="prettyprint linenums">echo ORM::factory('user')->generate_hash(10,'strong');
// output: o89#^g+CKN</pre>
  </div>
</div>
<br>

<h4>$object->enum_field_values()</h4>
<div class="row">
  <div class="span6">
    Get an array of Enum field values in the database.
    <br>
    <br>
    Very useful if you want to create selectboxes in your form with every enum field value as an option.
  </div>
  <div class="span6">
    <strong>example usage:</strong>
    <pre class="prettyprint linenums">echo Form::select('gender', $profile->enum_field_values('gender','Please select...'));</pre>
  </div>
</div>
<br>

<h4>Automatic dateformatting for date(time) or datetime field values</h4>
<div class="row">
  <div class="span6">
    Create new object attributes:
    <ul>
      <li>[date_field]_minutes</li>
      <li>[date_field]_hour</li>
      <li>[date_field]_datetime</li>
      <li>[date_field]_date</li>
    </ul>
  </div>
  <div class="span6">
    <strong>example usage:</strong>
    <pre class="prettyprint linenums" style="margin-bottom:0">echo ORM::factory('user')->updated_at_date;
// output: 16/02/2012
echo ORM::factory('user')->updated_at_datetime;
// output: 16/02/2012 14:45
    </pre>
  </div>
</div>

</div>

<div class="section" id="forms">
  <div class="section-header">
      <h3>Extended Kohana forms class</h3>
  </div>
  <h4>Auto add type as class to inputs</h4>
  Automatically add the type as classname to all input formfields. Useful for different styling for radiobuttons, checkboxes and text inputs.
  <br>
  <br>
  <h4>Auto add ID to formfields</h4>
  Automatically add the name value as ID to all input, textarea and select formfields. Useful for making the corresponding labels clickable.
</div>


<div class="section" id="messages">
  <div class="section-header">
      <h3>Added: messages class</h3>
  </div>
  A slightly altered version of the <a href="https://github.com/mixu/useradmin/blob/master/classes/useradmin/message.php">Message class</a> from
  Mixu's <a href="https://github.com/mixu/useradmin">Useradmin</a> application, to make it work nicely with Twitter Bootstrap.
</div>


<div class="section" id="pagination">
  <div class="section-header">
      <h3>Added module: pagination</h3>
  </div>
  For pagination on your pages. You can find more information about this module on <a href="https://github.com/kloopko/kohana-pagination">its Github page</a>
</div>

<div class="section" id="email">
  <div class="section-header">
      <h3>Added module: email</h3>
  </div>
  For sending out email. You can find more information about this module on <a href="https://github.com/Luwe/Kohana-Email">its Github page</a>
</div>