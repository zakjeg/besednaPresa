<div id="toast"></div>

<script>
      function showToast(message, position, type) {
        const toast = document.getElementById("toast");
        toast.className = toast.className + " show";

        if (message) toast.innerText = message;

        if (position !== "") toast.className = toast.className + ` ${position}`;
        if (type !== "") toast.className = toast.className + ` ${type}`;

        setTimeout(function () {
          toast.className = toast.className.replace(" show", "");
        }, 3000);
      }
      
    </script>
<?php get_message(); ?>
<script type="text/javascript" src="js/mdb.umd.min.js"></script>



<div style=" height: 20px;"></div>
<div style=" height: 20px; text-align: center;">

    <p>© 2024 Župnija Šmarjeta. Vse pravice zadržane.</p>
    <p>
      <a href="#about">About</a> | 
      <a href="#privacy">Privacy Policy</a> | 
      <a href="#contact">Contact</a>
    </p>

</div>
</body>
</html>