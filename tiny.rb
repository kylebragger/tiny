#
# Tiny
#
# A reversible base62 ID obfuscater
#
# Authors:
#  Jacob DeHart (original PHP version) and Kyle Bragger (Ruby port)
#

module Tiny
  TINY_SET = "__paste the result of generate_set() here__"
  
  class << self
    def tiny(id)
      hex_n = ''
      id = id.to_i.abs.floor
      radix = TINY_SET.length
      while true
        r = id % radix
        hex_n = TINY_SET[r,1] + hex_n
        id = (id - r) / radix
        break if id == 0
      end
      return hex_n
    end

    def untiny(str)
      radix = TINY_SET.length
      strlen = str.length
      n = 0
      (0..strlen - 1).each do |i|
        n += TINY_SET.index(str[i,1]) * (radix ** (strlen - i - 1))
      end
      return n.to_s
    end
    
    def generate_set
      base_set = ("a".."z").to_a + ("A".."Z").to_a + (0..9).to_a
      base_set = randomize_array(base_set).to_s
      puts "generate_set()"
      puts base_set
    end
    
    # Based on: http://www.ruby-forum.com/topic/92083#185073
    def randomize_array(arr)
      orig_a, new_a = arr.dup, []
      new_a << orig_a.slice!(rand(orig_a.size)) until new_a.size.eql?(arr.size)
      return new_a
    end
  end
end

# Test
puts Tiny::generate_set
puts Tiny::tiny(-12345)
puts Tiny::tiny(12345)
puts Tiny::tiny(64)
puts Tiny::tiny(1)
puts Tiny::tiny(0)
puts Tiny::untiny(Tiny::tiny(-12345))
puts Tiny::untiny(Tiny::tiny(12345))
puts Tiny::untiny(Tiny::tiny(64))
puts Tiny::untiny(Tiny::tiny(1))
puts Tiny::untiny(Tiny::tiny(0))
