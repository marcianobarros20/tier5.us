/**
 * Rows with columns
 */
(function() {
	tinymce.create('tinymce.plugins.columns', {
		init : function(ed, url) {
			// TODO fix this
			window.columnsImageUrl = url;

			ed.addButton('columns', {
				title: 'Columns',
				icon: 'us_columns',
				type: 'menubutton',
				menu: [
					{
						text: '2 columns',
						menu: [
							{
								text: '[____1/2____][____1/2____]',
								value: '[vc_row]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[__1/3__][______2/3______]',
								value: '[vc_row]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="2/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[______2/3______][__1/3__]',
								value: '[vc_row]<br />[vc_column width="2/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[_1/4_][_______3/4_______]',
								value: '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="3/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[_______3/4_______][_1/4_]',
								value: '[vc_row]<br />[vc_column width="3/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							}
						]
					},
					{
						text: '3 columns',
						menu: [
							{
								text: '[__1/3__][__1/3__][__1/3__]',
								value: '[vc_row]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[____1/2____][_1/4_][_1/4_]',
								value: '[vc_row]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[_1/4_][_1/4_][____1/2____]',
								value: '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							},
							{
								text: '[_1/4_][____1/2____][_1/4_]',
								value: '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
								onclick: function() {
									ed.insertContent(this.value());
								}
							}
						]
					},
					{
						text: '4 columns',
						value: '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]',
						onclick: function() {
							ed.insertContent(this.value());
						}
					}
				]
			});
		},
		createControl : function(n, cm) {
			switch (n) {
				case 'columns':
					var c = cm.createMenuButton('columns', {
						title : 'Add a row with columns',
						image : window.columnsImageUrl+'/columns.png',
						icons : false
					});

					c.onRenderMenu.add(function(c, m) {

						var sub2 = m.addMenu({title : '2 columns', alt: '...'});

						sub2.add({title : '[____1/2____][____1/2____]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub2.add({title : '[__1/3__][______2/3______]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="2/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub2.add({title : '[______2/3______][__1/3__]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="2/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub2.add({title : '[_1/4_][_______3/4_______]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="3/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub2.add({title : '[_______3/4_______][_1/4_]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="3/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});


						var sub3 = m.addMenu({title : '3 columns'});

						sub3.add({title : '[__1/3__][__1/3__][__1/3__]', /*icon: 'columns-one_third-one_third-one_third', */onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/3"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub3.add({title : '[____1/2____][_1/4_][_1/4_]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub3.add({title : '[_1/4_][_1/4_][____1/2____]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						sub3.add({title : '[_1/4_][____1/2____][_1/4_]', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/2"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});

						m.add({title : '4 columns', onclick : function() {
							tinyMCE.activeEditor.execCommand('mceInsertContent', false, '[vc_row]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[vc_column width="1/4"][vc_column_text] ... [/vc_column_text][/vc_column]<br />[/vc_row]');
						}});
					});

					// Return the new menu button instance
					return c;
			}

			return null;

		}
	});


	tinymce.PluginManager.add('columns', tinymce.plugins.columns);
})();


var buttonData = [{
	name: 'gallery',
	title: 'Add a Image Gallery',
	image: 'gallery.png',
	content: '[vc_gallery columns="1" ids="1,2" masonry="yes"]'
}, {
	name: 'slider',
	title: 'Add a Image Slider',
	image: 'slider.png',
	content: '[vc_simple_slider arrows="always" nav="none" transition="slide" ids="1,2,3" auto_rotation="yes"]'
}, {
	name: 'separator_btn',
	title: 'Add Separator',
	image: 'separator.png',
	content: '[vc_separator type="short" size="big" icon="star" text=""]'
}, {
	name: 'button_btn',
	title: 'Add Button',
	image: 'button.png',
	content: '[vc_button text="Click Me" type="primary" hover="secondary" corners="1" outlined="yes" bolded="yes" iconpos="left" hide_icon="yes" align="left" external="1" url="#" icon="star"]'
}, {
	name: 'tabs',
	title: 'Add Tabs',
	image: 'tabs.png',
	content: '[vc_tabs type="2"]<br>[vc_tab title="Tab 1" icon="star" active="yes"] ...[/vc_tab]<br>[vc_tab title="Tab 2"] ... [/vc_tab]<br>[/vc_tabs]'
}, {
	name: 'accordion',
	title: 'Add Accordion',
	image: 'accordion.png',
	content: '[vc_accordion toggle="no" title_center="yes"]<br>[vc_accordion_tab title="Section 1" icon="star" active="yes" no_indents="no" bg_color="" text_color=""][/vc_accordion_tab]<br>[vc_accordion_tab title="Section 2"][/vc_accordion_tab]<br>[/vc_accordion]'
}, {
	name: 'iconbox',
	title: 'Add Iconbox',
	image: 'iconbox.png',
	content: '[vc_iconbox icon="star" type="solid" color="primary" iconpos="top" size="small" title="Iconbox Title" link="#" external="0"] ... [/vc_iconbox]'
}, {
	name: 'testimonial',
	title: 'Add Testimonial',
	image: 'testimonial.png',
	content: '[vc_testimonial type="2" author="Name" company="Role" img=""] ... [/vc_testimonial]'
}, {
	name: 'team',
	title: 'Add Team Member',
	image: 'team.png',
	content: '[vc_member name="John Doe" role="Designer" img="" type="1" link="#" email="#" facebook="#" twitter="#" google_plus="#" linkedin="#" skype="#" custom_icon="star" custom_link="#"]'
}, {
	name: 'portfolio',
	title: 'Add Portfolio',
	image: 'projects.png',
	content: '[vc_portfolio columns="3" pagination="ajax" items="6" style="type_3" align="left" ratio="3:2" meta="category" filters="no" with_indents="yes" category=""]'
}, {
	name: 'blog',
	title: 'Add Blog',
	image: 'latest_posts.png',
	content: '[vc_blog type="masonry" items="6" pagination="ajax" show_date="yes" show_author="yes" show_categories="yes" show_tags="yes" show_comments="yes" show_read_more="yes" post_content="excerpt" category=""]'
}, {
	name: 'clients',
	title: 'Add Client Logos',
	image: 'clients.png',
	content: '[vc_clients columns="5" arrows="yes" auto_scroll="yes" interval="3"]'
}, {
	name: 'actionbox',
	title: 'Add ActionBox',
	image: 'actionbox.png',
	content: '[vc_actionbox type="alternate" title="This is ActionBox" message="" button_label="Click Me" button_link="#" button_color="primary" button_hover="secondary" button_corners="1" button_outlined="yes" button_bolded="yes" button_size="big" button_iconpos="right" button_iconhide="yes" button_target="1" button_icon="star"]'
}, {
	name: 'video',
	title: 'Add a Video',
	image: 'video.png',
	content: '[vc_video ratio="16-9" link="http://vimeo.com/62375781"]'
}, {
	name: 'message',
	title: 'Add Message Box',
	image: 'alert.png',
	content: '[vc_message color="success" icon="star" closing="yes"]I am message box. Click edit button to change this text.[/vc_message]'
}, {
	name: 'counter',
	title: 'Add a Counter',
	image: 'counter.png',
	content: '[vc_counter count="99" size="small" color="primary" title="Projects completed" prefix="" suffix=""]'
}, {
	name: 'contact_form',
	title: 'Add Contact Form',
	image: 'form.png',
	content: '[vc_contact_form form_email="" form_name_field="required" form_email_field="required" form_phone_field="required" form_message_field="required" button_color="primary" button_hover="secondary" button_outlined="" button_bolded="" button_align="left"]'
}, {
	name: 'pricing_table',
	title: 'Add Pricing Table',
	image: 'pricing.png',
	content: '[pricing_table style=1]<br>[pricing_column title="Standard" price="$10" time="per month"]<br>[pricing_row]Feature 1[/pricing_row]<br>[pricing_row]Feature 2[/pricing_row]<br>[pricing_footer url="#" color="light" type="flat"]Signup[/pricing_footer]<br>[/pricing_column]<br><br>[pricing_column title="Business" price="$20" time="per month" featured="1"]<br>[pricing_row]Feature 1[/pricing_row]<br>[pricing_row]Feature 2[/pricing_row]<br>[pricing_footer url="#" color="primary" type="flat"]Signup[/pricing_footer]<br>[/pricing_column]<br>[/pricing_table]'
}, {
	name: 'social_links',
	title: 'Social Links',
	image: 'social.png',
	content: '[vc_social_links size="normal" align="center" rounded="yes" outlined="yes" desaturated="yes" email="#" rss="" facebook="#" twitter="#" google="#" linkedin="#" youtube="#" vimeo="#" flickr="" instagram="" behance="" xing="" pinterest="" skype="" tumblr="" dribbble="" vk="" soundcloud="" yelp="" twitch=""]'
}, {
	name: 'gmaps',
	title: 'Add Google Maps',
	image: 'map.png',
	content: '[vc_gmaps address="1600 Amphitheatre Parkway, Mountain View, CA 94043, United States" type="ROADMAP" zoom="14" marker="Our Office" height="400" latitude="" longitude=""]'
}];

/**
 * Adding the buttons
 */
(function() {
	jQuery.each(buttonData, function(index, btn){
		tinymce.create('tinymce.plugins.'+btn.name, {
			init : function(ed, url) {
				ed.addButton(btn.name, {
					title : btn.title,
					image : url+'/'+btn.image,
					onclick : function() {
						ed.selection.setContent(btn.content);
					}
				});
			},
			createControl : function(n, cm) {
				return null;
			}
		});
		tinymce.PluginManager.add(btn.name, tinymce.plugins[btn.name]);
	});
})();
