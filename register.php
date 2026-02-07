<form action="eunoiaverse/service/database.php" id="register.php" menthod="POST">
    <div>
        <label for="first-name">First Name</label>
        <input type="text" id="first-name" class="neumorphic-inset p-2 mb-4" name="first-name" placeholder="First Name" required>
        <label for="last-name">Last Name</label>
       </div>
       <br>
       <div>
        <input type="text" id="last-name" class="neumorphic-inset p-2 mb-4" name="last-name" placeholder="Last Name" required>
        <label for="date">Birth Day</label>
        <input type="date" id="birthday-date" class="neumorphic-inset p-2 mb-4" name="birthday" placeholder="mm/dd/yyyy" required>
        <label for="address-map-input"> Address</label>
        <input type="text" id="address" class="neumorphic-inset p-2 mb-4" name="address" placeholder="Jl. Pelajar RT.003 NO.011, Linggang Bigung." required>
        <label for ="city">City</label>
        <input type="text" id="city" class="neumorphic-inset p-2 mb-4" name="city" placeholder="Kutai Barat" required>
        <label for="state">State:</label>
        <input type="text" id="state" class="neumorphic-inset p-2 mb-4" name="state" placeholder="Samarinda" required>
        <label for="numbers">Zip Code</label>
        <input type="text" id="zip" class="neumorphic-inset p-2 mb-4" name="zip" placeholder="Contoh 75572">
        <label for="country" aria-placeholder="country">Country:</label>
        <input type="text" id="country" class="neumorphic-inset p-2 mb-4" name="country" placeholder="Indonesia" required>
        <label for="phone" aria-placeholder="+62">Phone Number:</label>
        <input type="text" id="phone" class="neumorphic-inset p-2 mb-4" name="phone" placeholder="+625750928392" required>
      </div>
        <br>
        <div>
        <label for="username">Username</label>
        <input type="text" id="username" class="neumorphic-inset p-2 mb-4" name="username" placeholder="@edoerpani" required>
        <label for="email">Email</label>
        <input type="email" id="email" class="neumorphic-inset p-2 mb-4" name="email" placeholder="edoerpani@example.com" required>
        <label for="password">Password</label>
        <input type="password" id="password" class="neumorphic-inset p-2 mb-4" name="password" placeholder="minimal 8 karakter" required>
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" class="neumorphic-inset p-2 mb-4" name="confirm-password" placeholder="retype password" required>
        </div>
      <input type="submit" name="register" value="register">
    </div>
  </form>