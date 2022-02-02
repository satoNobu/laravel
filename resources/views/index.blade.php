<form action="form" method="POST" class="form-example">
  @csrf
    <p>name</p>
    <input type="text" name="name" id="name" value="{{ old("name") }}">
    <p>username</p>
    <input type="text" name="username" value="{{ old('username') }}">
    <p>age</p>
    <input type="text" name="info[age]" id="age" value="{{ old("info.age") }}">
    <p>sex</p>
    <input type="text" name="info[sex]" id="age" value="{{ old("info.age") }}">
    <p>checkbox<br>
      <input type="checkbox" name="ckbox" value="yes" checked>yes
      <input type="checkbox" name="ckbox" value="no">no
    </p>
    <p>birthday</p>
    <input type="date" name="birthday">
    <input type="submit" value="クリック">
</form>