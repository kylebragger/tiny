#
# Tiny
#
# A reversible base62 ID obfuscater
#
# Authors:
#  Jacob DeHart (original PHP version) and Kyle Bragger (Ruby port)
#

module Tiny
  TINY_SET = "Ed5M8ol0fUxNAJTcZYXyFsOvte2Sjmn43I6wBDah1kiKWbqCLpzQ79ugrPRVGH"
  
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
  end
end

# Test
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
