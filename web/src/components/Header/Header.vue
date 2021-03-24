<template>
  <header>
      <div class="logo">
        <a href="/">
          <img src="../../assets/images/logo.png" alt="Logo" />
        </a>
      </div>
      <nav class="menu">
				<ul class="">
					<li><a href="/register">REGISTRAR</a></li>
          <li><a href="/login">ENTRAR</a></li>
				</ul>
			</nav>
    </header>
</template>

<script>

export default {
  name: 'Header',
}
</script>

<style lang="scss">
  @import "./styles.scss";
</style>